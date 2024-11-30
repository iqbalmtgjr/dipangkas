<?php

namespace App\Livewire;

use App\Models\Mitra;
use Livewire\Component;
use App\Models\Kategori;
use Livewire\Attributes\On;
use Livewire\WithPagination;
use Livewire\WithoutUrlPagination;
use App\Models\Pangkas as PangkasModel;

class Pangkas extends Component
{
    use WithPagination, WithoutUrlPagination;
    // public $datas;
    public $paginate = 5;
    public $search;

    // #[On('pageChanged')]
    // public function mount()
    // {
    //     $this->datas = PangkasModel::all();
    // }

    public function render()
    {
        $total = PangkasModel::where('mitra_id', auth()->user()->mitra_id)->whereDate('created_at', now()->format('Y-m-d'))->sum('total_harga');
        // $total_dewasa = PangkasModel::where('mitra_id', auth()->user()->mitra_id)->whereDate('created_at', now()->format('Y-m-d'))->where('kategori_id', 1)->count();
        // $total_anak = PangkasModel::where('mitra_id', auth()->user()->mitra_id)->whereDate('created_at', now()->format('Y-m-d'))->where('kategori_id', 2)->count();

        $kategori = Kategori::where('mitra_id', auth()->user()->mitra_id)->get();
        return view('livewire.pangkas', [
            'datas' => PangkasModel::where('mitra_id', auth()->user()->mitra_id)
                ->whereDate('created_at', now()->format('Y-m-d'))
                ->orderBy('id', 'desc')
                ->paginate($this->paginate),
            'total' => $total,
            // 'total_dewasa' => $total_dewasa,
            // 'total_anak' => $total_anak,
            // 'total_dewasa_anak' => $total_dewasa + $total_anak,
            'kategoris' => $kategori
        ]);
    }

    public function pangkas($param)
    {
        $kategori = Kategori::find($param);
        if (!$kategori) {
            toastr()->error('Kategori tidak ditemukan.');
            return redirect()->back();
        }

        if (Mitra::where('id', auth()->user()->mitra_id)->first()->status == 0) {
            toastr()->error('Mitra anda belum divalidasi admin. Harap Hubungi admin.');
            return redirect()->back();
        }

        PangkasModel::create([
            'mitra_id' => auth()->user()->mitra_id,
            'user_id' => auth()->user()->id,
            'kategori_id' => $param,
            'total_harga' => $kategori->harga
        ]);

        toastr()->success('Transaksi berhasil!');
        $this->dispatch('pageChanged');
    }

    public function hapus($id)
    {
        $data = PangkasModel::find($id);
        $data->delete();

        toastr()->success('Berhasil hapus data.');
        $this->dispatch('pageChanged');
    }
}
