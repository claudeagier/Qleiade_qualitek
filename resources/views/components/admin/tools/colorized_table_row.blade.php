<div class="conformity-level-{{ $conformityLevel }}">
    @if ($emptyAttachment)
        <span class="empty-attachment-icon">
            <x-orchid-icon path="wrench" />
        </span>
    @endif
    {{ $value }}
</div>
<script>
    $(document).ready(function() {
        $("tr").has(".conformity-level-{{ $conformityLevel }}").addClass(
            "conformity-level-bg-{{ $conformityLevel }}")
    });
</script>
