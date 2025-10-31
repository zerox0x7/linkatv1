<?php

namespace App\Services;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Log;

class BunnyStorage
{
    private string $storageZone;
    private string $accessKey;
    private string $region;
    private string $pullZoneUrl;
    private ?array $lastError = null;

    public function __construct()
    {
        $this->storageZone = (string) config('services.bunny.storage_zone', '');
        $this->accessKey = (string) config('services.bunny.api_key', '');
        $this->region = (string) config('services.bunny.region', '');
        $this->pullZoneUrl = rtrim((string) config('services.bunny.pull_zone_url', ''), '/');
    }

    public function isConfigured(): bool
    {
        return $this->storageZone !== '' && $this->accessKey !== '' && $this->pullZoneUrl !== '';
    }

    public function getLastError(): ?array
    {
        return $this->lastError;
    }

    public function uploadUploadedFile(UploadedFile $file, string $destinationPath): ?string
    {
        $stream = fopen($file->getRealPath(), 'rb');
        if ($stream === false) {
            return null;
        }
        try {
            return $this->uploadStream($stream, $destinationPath);
        } finally {
            fclose($stream);
        }
    }

    public function uploadLocalPath(string $localPath, string $destinationPath): ?string
    {
        $stream = fopen($localPath, 'rb');
        if ($stream === false) {
            return null;
        }
        try {
            return $this->uploadStream($stream, $destinationPath);
        } finally {
            fclose($stream);
        }
    }

    private function uploadStream($stream, string $destinationPath): ?string
    {
        if (! $this->isConfigured()) {
            $this->lastError = ['reason' => 'not_configured'];
            return null;
        }

        // Read file content from stream into memory (matching Node.js implementation)
        $fileContent = stream_get_contents($stream);
        if ($fileContent === false) {
            $this->lastError = ['reason' => 'failed_to_read_stream'];
            return null;
        }

        $destinationPath = ltrim($destinationPath, '/');
        // Match Node.js implementation: use storage.bunnycdn.com without region prefix
        // Only add region prefix if explicitly needed (non-default regions)
        $region = strtolower(trim($this->region));
        $host = ($region && $region !== 'de' && $region !== '') ? $region.'.storage.bunnycdn.com' : 'storage.bunnycdn.com';
        $url = 'https://'.$host.'/'.$this->storageZone.'/'.$destinationPath;

        // Match Node.js: only use AccessKey header (no Content-Type)
        $headers = [
            'AccessKey: '.$this->accessKey,
        ];

        $ch = curl_init($url);
        // Use CURLOPT_CUSTOMREQUEST with PUT (matching Node.js axios.put)
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'PUT');
        curl_setopt($ch, CURLOPT_POSTFIELDS, $fileContent);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_TIMEOUT, 60);

        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $curlError = curl_error($ch);
        curl_close($ch);

        // Match Node.js: check if response has data (successful upload)
        if ($response === false || $curlError !== '' || $httpCode < 200 || $httpCode >= 300) {
            $this->lastError = [
                'http_code' => $httpCode,
                'curl_error' => $curlError,
                'response' => $response,
                'url' => $url,
            ];
            Log::error('Bunny upload failed', $this->lastError);
            return null;
        }

        return $this->publicUrl($destinationPath);
    }

    public function delete(string $path): bool
    {
        if (! $this->isConfigured()) {
            $this->lastError = ['reason' => 'not_configured'];
            return false;
        }
        
        $path = ltrim($path, '/');
        // Match Node.js example: use storage.bunnycdn.com without region prefix (unless specified)
        $region = strtolower(trim($this->region));
        $host = ($region && $region !== 'de' && $region !== '') ? $region.'.storage.bunnycdn.com' : 'storage.bunnycdn.com';
        $url = 'https://'.$host.'/'.$this->storageZone.'/'.$path;
        
        // Match example: only use AccessKey header
        $headers = [
            'AccessKey: '.$this->accessKey,
        ];
        
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'DELETE');
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_TIMEOUT, 30);
        
        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $curlError = curl_error($ch);
        curl_close($ch);
        
        // Check for success (200-299 range) or 404 (already deleted)
        if ($httpCode >= 200 && $httpCode < 300) {
            return true;
        }
        
        // 404 means file doesn't exist (already deleted), treat as success
        if ($httpCode === 404) {
            return true;
        }
        
        // Log error for other HTTP codes
        $this->lastError = [
            'http_code' => $httpCode,
            'curl_error' => $curlError,
            'response' => $response,
            'url' => $url,
        ];
        Log::warning('Bunny delete failed', $this->lastError);
        
        return false;
    }

    public function publicUrl(string $path): string
    {
        $path = ltrim($path, '/');
        return $this->pullZoneUrl.'/'.$path;
    }
}


