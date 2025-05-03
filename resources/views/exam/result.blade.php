<div class="container">
    <h1>Exam Result</h1>
    <p><strong>Score:</strong> {{ $score }} out of {{ $total }}</p>

    <a href="{{ route('exam.start') }}" class="btn btn-primary">Retake Exam</a>
</div>