<!DOCTYPE html>
<html>
<head>
    <title>Program Selection</title>
</head>
<body>
    <h1>Select a Degree Program</h1>
    
    <form method="post" action="{{ route('rollover') }}">
        @csrf
        <label for="program_id">Program Code:</label>
        <select name="program_id" id="program_id">
            @foreach ($programCodes as $programId => $programCode)
                <option value="{{ $programId }}">{{ $programCode }}</option>
            @endforeach
        </select>

        <button type="submit">Rollover</button>
    </form>
    
    @if(session('status'))
        <div>{{ session('status') }}</div>
    @endif
</body>
</html>
