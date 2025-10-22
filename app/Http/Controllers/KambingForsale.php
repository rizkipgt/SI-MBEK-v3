<?php

namespace App\Http\Controllers;

use App\Models\Kambing;
use App\Models\Domba;
use Illuminate\Http\Request;

class KambingForsale extends Controller
{
public function index(Request $request)
{
    $kategori = $request->input('kategori_produk', 'semua');
    $jenis    = $request->input('jenis');
    $q        = $request->input('q');
    $diskon   = $request->boolean('diskon');
    $sort     = $request->input('sort');
    $hargaMin = $request->input('harga_min');
    $hargaMax = $request->input('harga_max');

    if ($kategori === 'semua') {
        return $this->handleSemuaKategori($request, $diskon, $q, $sort, $hargaMin, $hargaMax);
    } else {
        return $this->handleSingleKategori($request, $kategori, $jenis, $diskon, $q, $sort, $hargaMin, $hargaMax);
    }
}

private function handleSemuaKategori($request, $diskon, $q, $sort, $hargaMin, $hargaMax)
{
    $kambingQuery = Kambing::query()->where('for_sale', 'yes');
    $dombaQuery = Domba::query()->where('for_sale', 'yes');

    // Filter berdasarkan diskon
    if ($diskon) {
        $kambingQuery->where('diskon', '>', 0);
        $dombaQuery->where('diskon', '>', 0);
    }

    // Filter berdasarkan pencarian
    if ($q) {
        $kambingQuery->where(function ($subQuery) use ($q) {
            $subQuery->where('name', 'like', "%{$q}%")
                ->orWhere('jenis_kelamin', 'like', "%{$q}%")
                ->orWhere('weight_now', 'like', "%{$q}%")
                ->orWhere('type_goat', 'like', "%{$q}%");
        });
        $dombaQuery->where(function ($subQuery) use ($q) {
            $subQuery->where('name', 'like', "%{$q}%")
                ->orWhere('jenis_kelamin', 'like', "%{$q}%")
                ->orWhere('weight_now', 'like', "%{$q}%")
                ->orWhere('type_domba', 'like', "%{$q}%");
        });
    }

    // Sorting
    $orderBy = 'created_at';
    $orderDir = 'desc';
    if ($sort === 'oldest') {
        $orderDir = 'asc';
    } elseif ($sort === 'price_low') {
        $orderBy = 'harga';
        $orderDir = 'asc';
    } elseif ($sort === 'price_high') {
        $orderBy = 'harga';
        $orderDir = 'desc';
    }
    $kambingQuery->orderBy($orderBy, $orderDir);
    $dombaQuery->orderBy($orderBy, $orderDir);

    // Filter berdasarkan harga
    if ($hargaMin !== null && $hargaMin !== '') {
        $kambingQuery->where('harga', '>=', (int)$hargaMin);
        $dombaQuery->where('harga', '>=', (int)$hargaMin);
    }
    if ($hargaMax !== null && $hargaMax !== '') {
        $kambingQuery->where('harga', '<=', (int)$hargaMax);
        $dombaQuery->where('harga', '<=', (int)$hargaMax);
    }

    // Ambil data kambing dan domba
    $kambings = $kambingQuery->get();
    $dombas = $dombaQuery->get();
    $allProduk = $kambings->concat($dombas);

    // Pagination
    $perPage = 10;
    $page = $request->input('page', 1);
    $pagedProduk = $allProduk->slice(($page - 1) * $perPage, $perPage)->values();
    $paginator = new \Illuminate\Pagination\LengthAwarePaginator(
        $pagedProduk,
        $allProduk->count(),
        $perPage,
        $page,
        ['path' => $request->url(), 'query' => $request->query()]
    );

    return view('forsale', [
        'kambings'    => $paginator,
        'dombas'      => collect(),
        'totalProduk' => $allProduk->count(),
    ]);
}


private function handleSingleKategori($request, $kategori, $jenis, $diskon, $q, $sort, $hargaMin, $hargaMax)
{
    $modelMap = [
        'kambing' => Kambing::class,
        'domba'   => Domba::class,
    ];

    if (!array_key_exists($kategori, $modelMap)) {
        abort(404, 'Kategori tidak ditemukan');
    }

    $model = $modelMap[$kategori];
    $query = $model::query()->where('for_sale', 'yes');

    // Filter berdasarkan diskon
    if ($diskon) {
        $query->where('diskon', '>', 0);
    }

    // Filter berdasarkan jenis
    if ($jenis) {
        if ($kategori === 'kambing') {
            $query->where('type_goat', $jenis);
        } elseif ($kategori === 'domba') {
            $query->where('type_domba', $jenis);
        }
    }

    // Filter berdasarkan pencarian
    if ($q) {
        $query->where(function ($subQuery) use ($q, $kategori) {
            $subQuery->where('name', 'like', "%{$q}%")
                     ->orWhere('jenis_kelamin', 'like', "%{$q}%")
                     ->orWhere('weight_now', 'like', "%{$q}%");

            if ($kategori === 'kambing') {
                $subQuery->orWhere('type_goat', 'like', "%{$q}%");
            } elseif ($kategori === 'domba') {
                $subQuery->orWhere('type_domba', 'like', "%{$q}%");
            }
        });
    }

    // Sorting
    switch ($sort) {
        case 'latest':
            $query->orderByDesc('created_at');
            break;
        case 'oldest':
            $query->orderBy('created_at');
            break;
        case 'price_low':
            $query->orderBy('harga', 'asc');
            break;
        case 'price_high':
            $query->orderBy('harga', 'desc');
            break;
        default:
            $query->orderByDesc('created_at');
    }

    // Filter berdasarkan harga
    if ($hargaMin !== null && $hargaMin !== '') {
        $query->where('harga', '>=', (int)$hargaMin);
    }
    if ($hargaMax !== null && $hargaMax !== '') {
        $query->where('harga', '<=', (int)$hargaMax);
    }

    // Ambil produk dengan pagination
    $produk = $query->paginate(10)->withQueryString();

    return view('forsale', [
        'kambings'     => $kategori === 'kambing' ? $produk : collect(),
        'dombas'       => $kategori === 'domba' ? $produk : collect(),
        'totalProduk'  => $produk->total(),
    ]);
}
}