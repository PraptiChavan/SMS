@include('layouts.a_header')
@include('layouts.a_sidebar')

<style>
    .form-group {
        position: relative; /* Make sure form-group is relatively positioned to position the counter */
    }

    .form-control {
        padding-right: 50px; /* Leaves space for the counter */
    }

    .char-counter {
        position: absolute;
        right: 10px; /* Shift the counter to the right */
        top: 81%; /* Vertically align the counter */
        transform: translateY(-50%); /* Ensure the counter is perfectly centered vertically */
        font-size: 13px;
        color: gray;
        background: transparent;
        padding: 10px;
        pointer-events: none;
    }

    /* New styles for legend */
    fieldset {
        position: relative;
        border-top: 2px solid #000; /* Horizontal line */
        margin-top: 20px;
        padding-top: 20px;
    }

    legend {
        position: absolute;
        top: -10px; /* Adjusts vertical alignment */
        left: 10px; /* Adjusts horizontal alignment */
        background: #fff; /* Cuts through the horizontal line */
        padding: 0 10px; /* Adds spacing around text */
        font-size: 14px; /* Adjust font size */
        color: #000; /* Adjust text color */
    }
</style> 

<main class="app-main">
    <div class="app-content-header">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-12">
                    <h3 class="mb-0">Edit Subjects</h3>
                </div>
            </div>
        </div>
    </div>
    <div class="app-content">
        <div class="container-fluid">
            <form action="{{ route('admin.subjects.update', ['id' => $subjects->id]) }}" method="POST">
                @csrf
                <div class="card">
                    <div class="card-body">
                        <div class="form-group">
                            <label for="name">Name</label>
                            <input type="text" name="name" value="{{ isset($subjects) ? $subjects->name : '' }}" class="form-control" id="name" maxlength="50" style="margin-top: 20px;" placeholder="Name" required oninput="updateCounter('name', 'nameCounter')">
                            <span id="nameCounter" class="char-counter">0/50</span>
                        </div>
                        <div class="form-group">
                            <label for="classes" style="margin-top: 20px;">Select Class</label>
                            <select name="classes" id="classes" class="form-control" style="margin-top: 20px;" required>
                                <option value="">Select Class</option>
                                @if(isset($classes) && $classes->isNotEmpty())
                                    @foreach ($classes as $class)
                                    <option value="{{ $class->id }}" 
                                        {{ isset($subjects) && $subjects->classes == $class->id ? 'selected' : '' }}>
                                        {{ $class->title }}
                                    </option>
                                    @endforeach
                                @else
                                    <option value="">No Classes Available</option>
                                @endif
                            </select>
                        </div>
                        <div class="form-group">
                            <label style="margin-top: 20px;">Sections</label>
                            @foreach($sections as $section)
                                <div>
                                    <label for="section_{{ $section->id }}">
                                        <input type="checkbox" name="sections[]" id="section_{{ $section->id }}" value="{{ $section->id }}"
                                            {{ in_array($section->id, explode(',', $subjects->sections)) ? 'checked' : '' }}>
                                        {{ $section->title }}
                                    </label>
                                </div>
                            @endforeach
                        </div>
                        <!-- Submit Button -->
                        <button type="submit" id="submitBtn" class="btn btn-success" style="margin-top: 20px;">
                        Update
                        </button>
                        <a href="{{ route('admin.subjects') }}" class="btn btn-danger" style="margin-top: 20px;">Cancel</a>
                    </div>
                </div>
            </form>
        </div>
    </div>
</main>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<!-- Script for updating counters -->
<script>
    function updateCounter(inputId, counterId) {
        let inputElement = document.getElementById(inputId);
        let counterElement = document.getElementById(counterId);
        counterElement.textContent = `${inputElement.value.length}/${inputElement.maxLength}`;
    }
</script>

@include('layouts.a_footer')
