<div class="text-center d-flex justify-content-center">    
    <a href="{{ route('apps.participant.edit', @$uuid) }}" class="me-4" title="Edit Participant">
        <i class="bx bx-pencil"></i>
    </a>
    
    <a href="#" class="btnDelete" data-uuid="{{ @$uuid }}" data-name="{{ @$nama }}" title="Delete Participant">
        <i class="bx bx-trash"></i>
    </a>
</div>
