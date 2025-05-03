<div class="container">
    <h1>Edit Question</h1>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>@foreach ($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul>
        </div>
    @endif

    <form method="POST" action="{{ route('questions.update', $question->id) }}">
        @csrf
        @method('PUT')
        @include('admin.questions.form', ['question' => $question])
        <button type="submit" class="btn btn-primary">Update</button>
        <a href="{{ route('questions.index') }}" class="btn btn-secondary">Cancel</a>
    </form>
</div>