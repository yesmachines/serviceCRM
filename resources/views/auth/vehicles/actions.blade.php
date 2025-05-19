<a href="{{ route('vehicles.edit', $vehicle->id) }}" class="text-reset px-2">
    <i class="ri-edit-2-fill" style="font-size: 20px; vertical-align: middle;"></i>
</a>



<a href="{{ route('vehicles.destroy', $vehicle->id) }}" class="text-danger px-2 destroy" style="cursor: pointer;">
    <i class="ri-delete-bin-2-line" style="font-size: 20px; vertical-align: middle;"></i>
</a>
