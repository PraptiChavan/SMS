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
                    <h3 class="mb-0">Edit Courses</h3>
                </div>
            </div>
        </div>
    </div>
    <div class="app-content">
        <div class="container-fluid">
            <form action="{{ route('admin.courses.update', ['id' => $courses->id]) }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="card">
                    <div class="card-body">
                        <div class="form-group">
                            <label for="name">Course Name</label>
                            <input type="text" name="name" value="{{ isset($courses) ? $courses->name : '' }}" class="form-control" id="name" maxlength="50" style="margin-top: 20px;" placeholder="Course Name" required oninput="updateCounter('name', 'nameCounter')">
                            <span id="nameCounter" class="char-counter">0/50</span>
                        </div>
                        <div class="form-group">
                            <label for="category" style="margin-top: 20px;">Course Category</label>
                            <select name="category" id="category" class="form-control" style="margin-top: 20px;">
                                <option value="">Select Category</option>
                                <option value="web-design-and-development" {{ isset($courses) && $courses->category == 'web-design-and-development' ? 'selected' : '' }}>Web Design & Development</option>
                                <option value="app-developement" {{ isset($courses) && $courses->category == 'app-developement' ? 'selected' : '' }}>App Development</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="duration" style="margin-top: 20px;">Course Duration</label>
                            <input type="text" id="duration" name="duration" value="{{ isset($courses) ? $courses->duration : '' }}" style="margin-top: 20px;" placeholder="Duration" required class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="date" style="margin-top: 20px;">Course Start Date</label>
                            <input type="date" id="date" name="date" value="{{ isset($courses) ? $courses->date : '' }}" style="margin-top: 20px; padding-right: 10px;" required class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="image" style="margin-top: 20px;">Course Image</label>
                            @if(isset($courses->image)) 
                                <br>
                                <img src="{{ asset('storage/' . $courses->image) }}" height="100" alt="Current Course Image">
                            @endif
                            <input type="file" id="image" name="image" style="margin-top: 20px;" class="form-control">
                        </div>
                        <!-- Submit Button -->
                        <button type="submit" id="submitBtn" class="btn btn-success" style="margin-top: 20px;">
                        Update
                        </button>
                        <a href="{{ route('admin.courses') }}" class="btn btn-danger" style="margin-top: 20px;">Cancel</a>
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
