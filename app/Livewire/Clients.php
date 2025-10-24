<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Builder;
use Carbon\Carbon;

class Clients extends Component
{
    use WithPagination;

    // Search and filters
    public $search = '';
    public $statusFilter = '';
    public $segmentFilter = '';
    public $sortBy = 'created_at';
    public $sortDirection = 'desc';
    public $perPage = 2;
    
    // Bulk actions
    public $selectedClients = [];
    public $selectAll = false;

    protected $queryString = [
        'search' => ['except' => ''],
        'statusFilter' => ['except' => ''],
        'segmentFilter' => ['except' => ''],
        'sortBy' => ['except' => 'created_at'],
        'sortDirection' => ['except' => 'desc'],
        'perPage' => ['except' => 10],
    ];

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingStatusFilter()
    {
        $this->resetPage();
    }

    public function updatingSegmentFilter()
    {
        $this->resetPage();
    }

    public function updatingPerPage()
    {
        $this->resetPage();
    }

    public function sortBy($field)
    {
        if ($this->sortBy === $field) {
            $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortBy = $field;
            $this->sortDirection = 'asc';
        }
    }

    public function updatedSelectAll($value)
    {
        if ($value) {
            $this->selectedClients = $this->getClientsQuery()->pluck('id')->toArray();
        } else {
            $this->selectedClients = [];
        }
    }

    public function deleteSelected()
    {
        if (!empty($this->selectedClients)) {
            User::whereIn('id', $this->selectedClients)->delete();
            $this->selectedClients = [];
            $this->selectAll = false;
            session()->flash('message', 'تم حذف العملاء المحددين بنجاح');
        }
    }

    public function deleteClient($clientId)
    {
        User::find($clientId)?->delete();
        session()->flash('message', 'تم حذف العميل بنجاح');
    }

    public function getClientsQuery()
    {
        $store = request()->attributes->get('store');
        
        return User::query()
            ->where('role', 'customer')
            ->where('store_id', $store->id)
            ->withCount(['orders'])
            ->withSum('orders', 'total')
            ->when($this->search, function (Builder $query) {
                $query->where(function ($q) {
                    $q->where('name', 'like', '%' . $this->search . '%')
                      ->orWhere('email', 'like', '%' . $this->search . '%')
                      ->orWhere('phone', 'like', '%' . $this->search . '%');
                });
            })
            ->when($this->statusFilter, function (Builder $query) {
                if ($this->statusFilter === 'active') {
                    $query->where('is_active', true);
                } elseif ($this->statusFilter === 'inactive') {
                    $query->where('is_active', false);
                }
            })
            ->when($this->segmentFilter, function (Builder $query) {
                if ($this->segmentFilter === 'vip') {
                    $query->where('vip', true);
                } elseif ($this->segmentFilter === 'new') {
                    $query->where('created_at', '>=', Carbon::now()->subDays(30));
                } elseif ($this->segmentFilter === 'regular') {
                    $query->where(function($q) {
                        $q->where('vip', false)->orWhereNull('vip');
                    })->where('created_at', '<', Carbon::now()->subDays(30));
                }
            })
            ->orderBy($this->sortBy, $this->sortDirection);
    }

    public function getClientsProperty()
    {
        return $this->getClientsQuery()->paginate($this->perPage);
    }

    public function getStatsProperty(Request $request)
    {
        $store = request()->attributes->get('store');
        $baseQuery = User::where('role', 'customer')->where('store_id', $store->id);
        
        $totalClients = $baseQuery->count();
        $activeClients = $baseQuery->where('is_active', true)->count();
        $newClients = $baseQuery->where('created_at', '>=', Carbon::now()->subDays(30))->count();
        $vipClients = $baseQuery->where('vip', true)->count();

        // Calculate growth percentages (comparing with previous month)
        $previousMonthStart = Carbon::now()->subMonths(2)->startOfMonth();
        $previousMonthEnd = Carbon::now()->subMonth()->endOfMonth();
        
        $prevTotalClients = User::where('role', 'user')
            ->where('created_at', '<=', $previousMonthEnd)
            ->count();
        
        $prevActiveClients = User::where('role', 'user')
            ->where('is_active', true)
            ->where('created_at', '<=', $previousMonthEnd)
            ->count();

        $prevNewClients = User::where('role', 'user')
            ->whereBetween('created_at', [$previousMonthStart, $previousMonthEnd])
            ->count();

        $prevVipClients = User::where('role', 'user')
            ->where('vip', true)
            ->where('created_at', '<=', $previousMonthEnd)
            ->count();

        return [
            'total' => $totalClients,
            'active' => $activeClients,
            'vip' => $vipClients,
            'new' => $newClients,
            'growth' => [
                'total' => $prevTotalClients > 0 ? round((($totalClients - $prevTotalClients) / $prevTotalClients) * 100, 1) : ($totalClients > 0 ? 100 : 0),
                'active' => $prevActiveClients > 0 ? round((($activeClients - $prevActiveClients) / $prevActiveClients) * 100, 1) : ($activeClients > 0 ? 100 : 0),
                'new' => $prevNewClients > 0 ? round((($newClients - $prevNewClients) / $prevNewClients) * 100, 1) : ($newClients > 0 ? 100 : 0),
                'vip' => $prevVipClients > 0 ? round((($vipClients - $prevVipClients) / $prevVipClients) * 100, 1) : ($vipClients > 0 ? 100 : 0),
            ]
        ];
    }

    public function getClientSegment($client)
    {
        // Use the vip field from database
        if ($client->vip === true || $client->vip === 1) {
            return 'vip';
        }
        
        // Check if user is new (created within last 30 days)
        $isNew = $client->created_at >= Carbon::now()->subDays(30);
        
        if ($isNew) {
            return 'new';
        }
        
        return 'regular';
    }

    public function formatLastActivity($lastLogin)
    {
        if (!$lastLogin) {
            return 'لم يسجل دخول مطلقاً';
        }
        
        $carbon = Carbon::parse($lastLogin);
        $now = Carbon::now();
        
        if ($carbon->isToday()) {
            return 'اليوم ' . $carbon->format('h:i A');
        } elseif ($carbon->isYesterday()) {
            return 'أمس ' . $carbon->format('h:i A');
        } elseif ($carbon->diffInDays($now) <= 7) {
            return 'منذ ' . $carbon->diffInDays($now) . ' أيام';
        } else {
            return $carbon->format('d/m/Y');
        }
    }

    public function formatPurchases($total, $count)
    {
        if ($total && $total > 0) {
            return number_format($total, 2) . ' ر.س';
        }
        
        return '0.00 ر.س';
    }

    public function refreshData()
    {
        // This method can be called to refresh the data
        $this->dispatch('data-refreshed');
    }

    public function render()
    {
        return view('livewire.clients', [
            'clients' => $this->clients,
            'stats' => $this->stats,
        ]);
    }
}
