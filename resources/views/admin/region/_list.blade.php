<table class="table table-bordered table-hover table-striped">
    <thead>
    <tr>
        <th>ID</th>
        <th>Имя</th>
        <th>Сео Урл</th>
        <th>Родительский регион</th>
    </tr>
    </thead>
    <tbody>
    @foreach($regions as $region)
        <tr>
            <td>{{$region->id}}</td>
            <td><a href="{{route('admin.region.show',$region)}}">{{$region->name}}</a></td>
            <td>{{$region->slug}}</td>
            <td>{{$region->parent?$region->parent->name:''}}</td>
        </tr>
    @endforeach
    </tbody>
</table>