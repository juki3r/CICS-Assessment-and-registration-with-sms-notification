<!DOCTYPE html>
<html>
<head>
    <title>Scoring Percentage Settings</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f3f4f6;
            margin: 0;
            padding: 40px;
        }
        .container {
            background: #fff;
            width: 400px;
            margin: auto;
            padding: 25px;
            border-radius: 12px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
        }
        h2 {
            text-align: center;
            margin-bottom: 20px;
            color: #333;
        }
        label {
            font-weight: bold;
            display: block;
            margin-top: 15px;
        }
        input {
            width: 100%;
            padding: 10px;
            margin-top: 5px;
            border: 1px solid #ccc;
            border-radius: 6px;
            font-size: 14px;
        }
        .error {
            color: #b91c1c;
            font-size: 13px;
            margin-top: 3px;
        }
        button {
            width: 100%;
            background: #4f46e5;
            color: white;
            border: none;
            padding: 12px;
            font-size: 16px;
            border-radius: 6px;
            margin-top: 20px;
            cursor: pointer;
        }
        button:hover {
            background: #4338ca;
        }
        .alert {
            background: #d1fae5;
            border: 1px solid #10b981;
            color: #065f46;
            padding: 10px;
            border-radius: 8px;
            margin-bottom: 15px;
            text-align: center;
        }
    </style>
</head>
<body>

<div class="container">
    <h2>Scoring Percentage</h2>

    @if (session('status'))
        <div class="alert">{{ session('status') }}</div>
    @endif

    <form method="POST" action="{{ route('scoring.update') }}">
        @csrf

        <label for="interview">Interview (e.g., 0.20)</label>
        <input type="number" step="0.01" name="interview" id="interview"
               value="{{ old('interview', $scoring->interview ?? 0) }}" required>
        @error('interview')
            <div class="error">{{ $message }}</div>
        @enderror

        <label for="gwa">GWA (e.g., 0.30)</label>
        <input type="number" step="0.01" name="gwa" id="gwa"
               value="{{ old('gwa', $scoring->gwa ?? 0) }}" required>
        @error('gwa')
            <div class="error">{{ $message }}</div>
        @enderror

        <label for="skilltest">Skill Test (e.g., 0.50)</label>
        <input type="number" step="0.01" name="skilltest" id="skilltest"
               value="{{ old('skilltest', $scoring->skilltest ?? 0) }}" required>
        @error('skilltest')
            <div class="error">{{ $message }}</div>
        @enderror

        <label for="exam">Exam (e.g., 0.25)</label>
        <input type="number" step="0.01" name="exam" id="exam"
               value="{{ old('exam', $scoring->exam ?? 0) }}" required>
        @error('exam')
            <div class="error">{{ $message }}</div>
        @enderror

        <button type="submit">Save Changes</button>
    </form>
</div>

</body>
</html>
