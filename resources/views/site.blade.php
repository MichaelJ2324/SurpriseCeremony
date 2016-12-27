<!DOCTYPE HTML>
<html>
<head>
    <title>Surprise Ceremony</title>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
    <link rel="stylesheet" href="{{ asset('css/site.css') }}" />
    <script src="{{ asset('js/ga.js') }}"></script>
</head>
<body>
<div class="container">
    <div class="row">
        <div class="Absolute-Center is-Responsive">
            <div class="col-sm-12 col-md-10 col-md-offset-1">
                <div class="panel form-panel">
                    <div class="panel-body">
                        <h2>You're Invited!</h2>
                        <p>Please enter access code to view ceremony details.</p>
                        <form method="POST" action="/code" class="form">
                            {{ csrf_field() }}
                            <div class="form-group">
                                <label class='sr-only' for="accessCode">Access Code</label>
                                <input type="text" class="form-control" id="accessCode" name="accessCode" placeholder="Access Code">
                            </div>
                            <button type="submit" class="btn btn-primary btn-block">Submit</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<!-- Scripts -->
<script src="{{ asset('js/site.js') }}"></script>
</body>
</html>