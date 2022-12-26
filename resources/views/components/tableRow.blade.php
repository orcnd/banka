<tr>
    @foreach ($item['columns'] as $column => $columnData)
    <td>

        @if ($columnData['type'] == 'text')
        {{$item['row'][$columnData['name']]}}
        @endif

        @if ($columnData['type'] == 'money')
        {{$item['row'][$columnData['name']]}}
        @endif

        @if ($columnData['type'] == 'textarea')
        {{Str::limit($item['row'][$columnData['name']],200)}}
        @endif

        @if ($columnData['type'] == 'select')
        {{$item['row'][$columnData['name']]}}
        @endif

        @if ($columnData['type'] == 'user')
        {{$item['row'][$columnData['name']]->name}}
        @endif
    </td>
    @endforeach
</tr>
