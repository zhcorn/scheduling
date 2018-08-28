<script data-exec-on-popstate>
    $(function () {
        $('.run-task').click(function (e) {
            var id = $(this).data('id');
            NProgress.start();
            $.ajax({
                method: 'POST',
                url: '{{ route('scheduling-run') }}',
                data: {id: id, _token: LA.token},
                success: function (data) {
                    if (typeof data === 'object') {
                        $('.output-card').removeClass('hide');
                        $('.output-card .output-body').html(data.data);
                    }
                    NProgress.done();
                }
            });
        });
    });
</script>

<style>
    .output-body {
        white-space: pre-wrap;
        background: #000000;
        color: #00fa4a;
        padding: 10px;
        border-radius: 0;
    }

</style>

<div class="card">
    <!-- /.card-header -->
    <div class="card-body p-0">
        <table class="table table-striped table-hover">
            <tbody>
            <tr>
                <th style="width: 10px">#</th>
                <th>Task</th>
                <th>Run at</th>
                <th>Next run time</th>
                <th>Description</th>
                <th>Run</th>
            </tr>
            @foreach($events as $index => $event)
            <tr>
                <td>{{ $index+1 }}.</td>
                <td><code>{{ $event['task']['name'] }}</code></td>
                <td><span class="badge bg-success">{{ $event['expression'] }}</span>&nbsp;{{ $event['readable'] }}</td>
                <td>{{ $event['nextRunDate'] }}</td>
                <td>{{ $event['description'] }}</td>
                <td><a href="#" class="btn btn-xs btn-primary run-task" data-id="{{ $index+1 }}">Run</a></td>
            </tr>
            @endforeach
            </tbody>
        </table>
    </div>
    <!-- /.card-body -->
</div>

<div class="card card-default output-card hide">
    <div class="card-header with-border">
        <i class="fa fa-terminal"></i>

        <h3 class="card-title">Output</h3>
    </div>
    <!-- /.card-header -->
    <div class="card-body">
        <pre class="output-body"></pre>
    </div>
    <!-- /.card-body -->
</div>