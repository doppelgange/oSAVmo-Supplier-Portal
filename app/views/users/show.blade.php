    <h2 class="form-signup-heading text-center">The user information:</h2>
 
    <ul>
        @foreach($errors->all() as $error)
            <li>{{ $error }}</li>
        @endforeach
    </ul>

    <div>
        <label> First Name</label>
        <span>{{ $user->firstname }}</span>
    </div>

    <div>
        <label> Last Name</label>
        <span>{{$user->lastname }}</span>
    </div>

    <div>
        <label> Supplier Name</label>
        <span>{{ $supplierName}}</span>
    </div>


    <div>
        <label> Email</label>
        <span>{{$user->email }}</span>
    </div>

    <a href="../users/{{$user->id}}/edit" class="btn btn-primary"> Edit</a>