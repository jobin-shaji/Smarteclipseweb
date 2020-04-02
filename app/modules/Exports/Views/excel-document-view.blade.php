<table>
    <thead>
        <tr>
            @foreach($columns as $column)
                <th>{{ $column }}</th>
            @endforeach
        </tr>
    </thead>
    <tbody>
        
        @foreach($data as $key  => $raw_data)
            <tr> 
                @foreach($columns as $column)
                    <td>{{ $data[$key][$column] }}</td>
                @endforeach  
            </tr>
        @endforeach
    </tbody>
</table>