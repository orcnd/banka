<table class="table table-striped">
    <thead>
        <tr>
            @foreach ($columns as $column => $columnData)
            <th scope="col">{{__($columnData['text'])}}</th>
            @endforeach
        </tr>
    </thead>
    <tbody>

    @foreach($data as $d)
        @include('components.tableRow',['item'=>['columns'=>$columns,'row'=>$d]])
    @endforeach
    </tbody>
</table>

