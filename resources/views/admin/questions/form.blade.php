@php
    $questionText = old('question', $question->question ?? '');
    $optionA = old('option_a', $question->option_a ?? '');
    $optionB = old('option_b', $question->option_b ?? '');
    $optionC = old('option_c', $question->option_c ?? '');
    $optionD = old('option_d', $question->option_d ?? '');
    $correct = old('correct_answer', $question->correct_answer ?? '');
@endphp

<div class="mb-3">
    <label>Question</label>
    <input type="text" name="question" class="form-control" value="{{ $questionText }}" required>
</div>
<div class="mb-3">
    <label>Option A</label>
    <input type="text" name="option_a" class="form-control" value="{{ $optionA }}" required>
</div>
<div class="mb-3">
    <label>Option B</label>
    <input type="text" name="option_b" class="form-control" value="{{ $optionB }}" required>
</div>
<div class="mb-3">
    <label>Option C</label>
    <input type="text" name="option_c" class="form-control" value="{{ $optionC }}" required>
</div>
<div class="mb-3">
    <label>Option D</label>
    <input type="text" name="option_d" class="form-control" value="{{ $optionD }}" required>
</div>
<div class="mb-3">
    <label>Correct Answer</label>
    <select name="correct_answer" class="form-control" required>
        <option value="">--Select--</option>
        <option value="a" {{ $correct === 'a' ? 'selected' : '' }}>A</option>
        <option value="b" {{ $correct === 'b' ? 'selected' : '' }}>B</option>
        <option value="c" {{ $correct === 'c' ? 'selected' : '' }}>C</option>
        <option value="d" {{ $correct === 'd' ? 'selected' : '' }}>D</option>
    </select>
</div>
