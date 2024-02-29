@if ($data)
    @php
        $i = 1;
    @endphp
    @foreach ($data as $item)
        <tr>
            <td>{{ $i }}</td>
            <td>{{ $item->kegiatan }}</td>
            <td>{{ $item->tahun }}</td>
            <td>{{ $item->tanggal_dari }}-{{ $item->tanggal_sampai }}</td>
            <td>{{ $item->waktu_dari }}-{{ $item->waktu_sampai }}</td>
            @if ($item->status == 'Belum Mulai')
                <td><i class="btn btn-danger">{{ $item->status }}</i></td>
            @elseif ($item->status == 'Sudah Mulai')
                <td><i class="btn btn-warning">{{ $item->status }}</i></td>
            @else
                <td><i class="btn btn-success">{{ $item->status }}</i></td>
            @endif

            <td><a class="btn btn-outline-dark"
                    href="{{ route('kandidat.show', ['kandidat' => $item->id]) }}">Kandidat</a></td>

            <td><a class="btn btn-outline-dark" href="{{ route('kegiatan.show', ['kegiatan' => $item->id]) }}">Lihat</a>
            </td>
            <td>
                <button type="button" class="btn btn-outline-secondary" data-toggle="modal"
                    data-target="#editKandidatModal{{ $item->id }}">
                    Edit
                </button>

                <form action="{{ route('kegiatan.destroy', ['kegiatan' => $item->id]) }}" method="POST"
                    style="display: inline;">
                    @csrf
                    @method('DELETE')
                    <button class="btn btn-outline-secondary" type="submit"
                        onclick="return confirm('Anda yakin ingin menghapus data ini?')">Delete</button>
                </form>
            </td>
        </tr>
        @php
            $i++;
        @endphp
    @endforeach
@else
    <p class="text-danger text-center">Data tidak ditemukan</p>
@endif
