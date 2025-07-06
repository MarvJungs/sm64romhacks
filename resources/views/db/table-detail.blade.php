<x-layout>
    <h1 class="text-center">{{$table->name}}</h1>
    <hr />
    
    <table class="table table-bordered table-hover">
        <thead>
            <tr>
                @foreach ($table->header as $item)
                    <th>
                        {{$item}}
                    </th>
                @endforeach
                <th>
                    Action
                </th>
            </tr>
        </thead>
        <tbody>
            @foreach ($table->rows as $row)
                <tr>
                    @foreach ($row as $col)
                        <td>
                            {{$col}}
                        </td>
                    @endforeach
                    <td>
                        <a class="btn btn-warning" href="{{url()->current()}}/edit/{{$row->id}}">
                            <img src="/icons/edit.svg" />    
                        </a> 
                        <a class="btn btn-danger" href="{{url()->current()}}/delete/{{$row->id}}">
                            <img src="/icons/delete.svg" />    
                        </a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    
</x-layout>