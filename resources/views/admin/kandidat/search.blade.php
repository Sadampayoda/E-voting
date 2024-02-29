@if ($data)
    @php
        $i = 1;
    @endphp
    @foreach ($data as $item)
        <tr>
            <td>{{ $i }}</td>
            <td><img src="{{ asset('image/kandidat/' . $item->foto) }}" width="75" height="75" alt=""></td>
            <td>{{ $item->nama }}</td>
            <td>{{ $item->nik }}</td>
            <td><button class="btn btn-dark" type="button" data-toggle="modal"
                    data-target="#detailKandidatModal{{ $item->id }}">Visi Misi dan wakil</td>

            <td>
                <button type="button" class="btn btn-outline-secondary" data-toggle="modal"
                    data-target="#editKandidatModal{{ $item->id }}">
                    Edit
                </button>

                <form action="{{ route('kandidat.destroy', ['kandidat' => $item->id]) }}" method="POST"
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
