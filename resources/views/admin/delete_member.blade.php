
<form action="{{ route('members.destroy', $member->id) }}" method="POST" style="display: inline-block;">
    @csrf
    @method('DELETE')
    <button type="submit" class="btn btn-outline-danger btn-sm">Delete</button>
</form>

