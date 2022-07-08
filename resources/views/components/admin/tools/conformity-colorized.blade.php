<div class = "conformity-level-{{$conformityLevel}}">
    {{ $value }}
</div>
<script>
    $(document).ready(function()
    {
        $("tr").has(".conformity-level-{{$conformityLevel}}").addClass("conformity-level-bg-{{$conformityLevel}}");
    });
</script>