<!DOCTYPE html>
<form action="{{ route('student.rollOver') }}" method="POST">
    @csrf
    <button type="submit">Roll Over Students</button>
</form>

@if(session('status'))
    <div class="alert alert-success">
        {{ session('status') }}
    </div>
@endif

</html>
