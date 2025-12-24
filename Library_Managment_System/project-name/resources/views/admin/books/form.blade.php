@csrf

<div class="mb-3">
    <label class="form-label">ISBN</label>
    <input name="ISBN" value="{{ $book->ISBN ?? old('ISBN') }}" class="form-control" {{ isset($book) ? 'readonly' : '' }}>
    @error('ISBN') <div class="text-danger">{{ $message }}</div> @enderror
</div>
<div class="mb-3">
    <label class="form-label">Title</label>
    <input name="Title" value="{{ $book->Title ?? old('Title') }}" class="form-control">
    @error('Title') <div class="text-danger">{{ $message }}</div> @enderror
</div>
<div class="mb-3">
    <label class="form-label">Price</label>
    <input name="Price" value="{{ $book->Price ?? old('Price') }}" class="form-control">
    @error('Price') <div class="text-danger">{{ $message }}</div> @enderror
</div>
<div class="mb-3">
    <label class="form-label">Quantity</label>
    <input name="Quantity" value="{{ $book->Quantity ?? old('Quantity') }}" class="form-control">
    @error('Quantity') <div class="text-danger">{{ $message }}</div> @enderror
</div>
<div class="mb-3">
    <label class="form-label">Category</label>
    <select name="CategoryID" class="form-control">
        <option value="">--</option>
        @foreach($categories as $cat)
            <option value="{{ $cat->CategoryID }}" {{ isset($book) && $book->CategoryID == $cat->CategoryID ? 'selected' : '' }}>{{ $cat->CategoryName }}</option>
        @endforeach
    </select>
</div>
<div class="mb-3">
    <label class="form-label">Publisher</label>
    <select name="PublisherID" class="form-control">
        <option value="">--</option>
        @foreach($publishers as $p)
            <option value="{{ $p->PublisherID }}" {{ isset($book) && $book->PublisherID == $p->PublisherID ? 'selected' : '' }}>{{ $p->Name }}</option>
        @endforeach
    </select>
</div>