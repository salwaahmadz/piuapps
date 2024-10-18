<div class="text-center d-flex justify-content-center">    
    <a href="{{ route('apps.category.edit', @$id) }}" class="me-4" title="Edit Category">
        <i class="bx bx-pencil"></i>
    </a>
    
    <a href="#" class="btnDelete" data-id="{{ @$id }}" data-name="{{ @$name }}" title="Delete Category">
        <i class="bx bx-trash"></i>
    </a>
</div>
