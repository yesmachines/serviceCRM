<a href="{{ route('vehicles.edit', $vehicle->id) }}" class="text-reset px-2">
    <i class="ri-edit-2-fill" style="font-size: 20px; vertical-align: middle;"></i>
</a>

<!-- <form action="{{ route('vehicles.destroy', $vehicle->id) }}" method="POST" style="display:inline;">
    @csrf
    @method('DELETE')
    <button type="submit" class="btn btn-link text-danger px-2 destroy" style="padding: 0; border: none; background: none;">
        <i class="ri-delete-bin-2-line" style="font-size: 20px; vertical-align: middle;"></i>
    </button>
</form> -->

<a href="{{ route('vehicles.destroy', $vehicle->id) }}" class="text-danger px-2 destroy" style="cursor: pointer;">
    <i class="ri-delete-bin-2-line" style="font-size: 20px; vertical-align: middle;"></i>
</a>
