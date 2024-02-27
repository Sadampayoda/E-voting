@if ($data)

    @php
        $i = 1;
    @endphp
    @foreach ($data as $item)
        <tr>
            <td>{{ $i }}</td>
            <td><img src="{{ asset('image/users/' . $item->foto) }}" width="75" height="75"></td>
            <td>{{ $item->name }}</td>
            <td>{{ $item->email }}</td>
            <td>{{ $item->nik }}</td>
            <td>{{ $item->jenis_kelamin }}</td>
            <td>
                <a href="{{ route('user-manejement.edit', ['user_manejement' => $item->id]) }}"
                    class="btn btn-outline-secondary">Edit</a>
                <form action="{{ route('user-manejement.destroy', ['user_manejement' => $item->id]) }}" method="POST"
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
