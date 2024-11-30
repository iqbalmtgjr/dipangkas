<?php

namespace App\Livewire;

use Carbon\Carbon;
use Livewire\Component;
use App\Models\Kategori;
use Livewire\Attributes\On;
use Livewire\WithPagination;
use Livewire\WithoutUrlPagination;
use App\Models\Pangkas as PangkasModel;

class Laporan extends Component
{
    use WithPagination, WithoutUrlPagination;
    // public $datas;
    public $paginate = 5;
    public $search;
    public $startDate;
    public $endDate;
    public $laporan = [];

    public function filter()
    {
        $this->validate([
            'startDate' => 'required|date',
            'endDate' => 'required|date|after_or_equal:startDate',
        ], [
            'startDate.required' => 'Tanggal awal harus diisi',
            'endDate.required' => 'Tanggal akhir harus diisi',
            'endDate.after_or_equal' => 'Tanggal akhir harus lebih atau sama dengan tanggal awal',
        ]);

        $this->dispatch('pageChanged');
    }

    public function resetfilter()
    {
        $this->startDate = null;
        $this->endDate = null;
        $this->dispatch('pageChanged');
    }

    #[On('pageChanged')]
    public function render()
    {
        if (empty($this->startDate) || empty($this->endDate)) {
            $data = PangkasModel::where('mitra_id', auth()->user()->mitra_id)
                ->orderBy('id', 'desc')
                ->paginate($this->paginate);

            $data2 = PangkasModel::where('mitra_id', auth()->user()->mitra_id)
                ->orderBy('id', 'desc')
                ->get();
        } elseif ($this->startDate == $this->endDate) {
            $data = PangkasModel::where('mitra_id', auth()->user()->mitra_id)
                ->whereDate('created_at', $this->startDate)
                ->orderBy('id', 'desc')
                ->paginate($this->paginate);

            $data2 = PangkasModel::where('mitra_id', auth()->user()->mitra_id)
                ->whereDate('created_at', $this->startDate)
                ->orderBy('id', 'desc')
                ->get();
        } else {
            $data = PangkasModel::where('mitra_id', auth()->user()->mitra_id)
                ->whereDate('created_at', '>=', $this->startDate)
                ->whereDate('created_at', '<=', $this->endDate)
                ->orderBy('id', 'desc')
                ->paginate($this->paginate);

            $data2 = PangkasModel::where('mitra_id', auth()->user()->mitra_id)
                ->whereDate('created_at', '>=', $this->startDate)
                ->whereDate('created_at', '<=', $this->endDate)
                ->orderBy('id', 'desc')
                ->get();
        }

        $total = $data2->sum(fn($pangkas) => $pangkas->total_harga);
        $total_dewasa = $data2->where('kategori_id', 1)->count();
        $total_anak = $data2->where('kategori_id', 2)->count();

        return view('livewire.laporan', [
            'datas' => $data,
            'total' => $total,
            'total_dewasa' => $total_dewasa,
            'total_anak' => $total_anak,
            'total_dewasa_anak' => $total_dewasa + $total_anak
        ]);
    }
}
