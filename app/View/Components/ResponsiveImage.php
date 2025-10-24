<?php

namespace App\View\Components;

use Illuminate\View\Component;
use Illuminate\Support\Facades\Storage;

class ResponsiveImage extends Component
{
    public $src;
    public $srcset;
    public $sizes;
    public $alt;
    public $class;
    public $style;
    public $loading;
    
    /**
     * Create a new component instance.
     *
     * @param array|string $image The image path (array for responsive, string for single)
     * @param string $alt Alt text for the image
     * @param string|null $class CSS classes
     * @param string|null $style Inline styles
     * @param string $size Preferred size when not using srcset
     * @param string $loading Loading strategy (lazy, eager, auto)
     * @param string $disk Storage disk
     */
    public function __construct(
        $image, 
        $alt = '', 
        $class = null, 
        $style = null, 
        $size = 'large',
        $loading = 'lazy',
        $disk = 'public'
    ) {
        $this->alt = $alt;
        $this->class = $class;
        $this->style = $style;
        $this->loading = $loading;
        
        // Generate src, srcset, and sizes attributes
        if (is_array($image)) {
            // Responsive image - generate srcset
            $this->src = $this->getImageUrl($image, $size, $disk);
            $this->srcset = $this->generateSrcset($image, $disk);
            $this->sizes = $this->generateSizes();
        } else {
            // Single image - no srcset
            $this->src = Storage::disk($disk)->url($image);
            $this->srcset = null;
            $this->sizes = null;
        }
    }
    
    /**
     * Get image URL for a specific size
     */
    protected function getImageUrl($imagePath, $size, $disk)
    {
        if (isset($imagePath[$size])) {
            return Storage::disk($disk)->url($imagePath[$size]);
        }
        
        if (isset($imagePath['default'])) {
            return Storage::disk($disk)->url($imagePath['default']);
        }
        
        if (isset($imagePath['large'])) {
            return Storage::disk($disk)->url($imagePath['large']);
        }
        
        return Storage::disk($disk)->url(reset($imagePath));
    }
    
    /**
     * Generate srcset attribute
     */
    protected function generateSrcset($imagePath, $disk)
    {
        $sizes = [
            'thumbnail' => 150,
            'small' => 480,
            'medium' => 768,
            'large' => 1200,
        ];
        
        $srcset = [];
        
        foreach ($sizes as $sizeName => $width) {
            if (isset($imagePath[$sizeName])) {
                $url = Storage::disk($disk)->url($imagePath[$sizeName]);
                $srcset[] = $url . ' ' . $width . 'w';
            }
        }
        
        return !empty($srcset) ? implode(', ', $srcset) : null;
    }
    
    /**
     * Generate sizes attribute
     */
    protected function generateSizes()
    {
        return '(max-width: 150px) 150px, (max-width: 480px) 480px, (max-width: 768px) 768px, 1200px';
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.responsive-image');
    }
}

