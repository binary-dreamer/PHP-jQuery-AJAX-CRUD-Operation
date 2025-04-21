

<div class="container mt-5">
  <form id="userForm" method="POST" enctype="multipart/form-data">
    <input type="hidden" name="id" id="id" value="">
    <input type="hidden" name="action" id="action" value="create">
    <div class="form-group">
      <label for="name">Name</label>
      <input type="text" class="form-control" id="name" name="name" required>
    </div>
    <div class="mb-3">
      <label for="gender-f">Gender</label><br>
      <input type="radio" name="gender" value="female" id="gender-f"> Female
      <input type="radio" name="gender" value="male" id="gender-m"> Male
    </div>
    <div class="form-group">
      <label for="email">Email</label>
      <input type="email" class="form-control" id="email" name="email" required>
    </div>
    <div class="form-group">
      <label for="password">Password</label>
      <input type="password" class="form-control" id="password" name="password">
    </div>
    <div class="form-group">
    <label for="photo">Photo</label>
    <input type="file" class="form-control" id="photo" name="photo" onchange="previewPhoto(event)">
    <img id="photo-preview" src="#" alt="Photo Preview" style="display:none; max-width: 150px; margin-top: 10px;">
</div>
    <button type="submit" id="btn">Submit</button>
  </form>
</div>
<br>

