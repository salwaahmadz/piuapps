<div class="text-center d-flex justify-content-center">    
    <a href="{{ route('apps.mentor.edit', @$uuid) }}" class="me-4" title="Edit Mentor">
        <i class="bx bx-pencil"></i>
    </a>
    
    <a href="#" class="btnDelete" data-uuid="{{ @$uuid }}" data-name="{{ @$name }}" title="Delete Mentor">
        <i class="bx bx-trash"></i>
    </a>
</div>
