<table class="table table-bordered table-hover table-striped">
    <thead>
    <tr>
        <th>Имя</th>
        <th>Сео Урл</th>
        <th>Сортировка</th>
    </tr>
    </thead>
    <tbody>
    @foreach($categories as $category)
        <tr>
            <td>
                @for($i = 0; $i <$category->depth; $i++) &mdash; @endfor
                    <a href="{{route('admin.adverts.category.show',$category)}}">{{$category->name}}</a>
            </td>
            <td>{{$category->slug}}</td>
            <td>
                <div class="d-flex flex-row">
                    <form method="POST" action="{{route('admin.adverts.category.first',$category)}}" class="mr-1">
                        @csrf
                        <button class="btn btn-sm btn-outline-primary"><span class="fa fa-angle-double-up"></span></button>
                    </form>
                    <form method="POST" action="{{route('admin.adverts.category.up',$category)}}" class="mr-1">
                        @csrf
                        <button class="btn btn-sm btn-outline-primary"><span class="fa fa-angle-up"></span></button>
                    </form>
                    <form method="POST" action="{{route('admin.adverts.category.down',$category)}}" class="mr-1">
                        @csrf
                        <button class="btn btn-sm btn-outline-primary"><span class="fa fa-angle-down"></span></button>
                    </form>
                    <form method="POST" action="{{route('admin.adverts.category.last',$category)}}" class="mr-1">
                        @csrf
                        <button class="btn btn-sm btn-outline-primary"><span class="fa fa-angle-double-down"></span></button>
                    </form>
                </div>
            </td>
        </tr>
    @endforeach
    </tbody>
</table>