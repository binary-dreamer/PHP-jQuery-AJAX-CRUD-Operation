<?php require_once __DIR__ . "/../layout/header.php";
require_once __DIR__ . "/../user-view/user-form.php";
// $baseUrl = '/jquery_crud';


var_dump($user);
?>


<div class="container">
    <h3 class="" align="center">User Data</h3>

    <label for="pageSizeSelector">Rows per page:</label>
    <select id="pageSizeSelector">
        <option value="5">5</option>
        <option value="10">10</option>
        <option value="15">15</option>
        <option value="20">20</option>
        <option value="25">25</option>
        <option value="30">30</option>
        <option value="50">50</option>
        <option value="100">100</option>
    </select>
    <table class="table" id="userTable">
        <thead>
            <tr>
                <th>Srno.</th>
                <th>Name</th>
                <th>Email</th>
                <th>Gender</th>
                <th>Image</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>

            <?php if (is_array($user) && !empty($user)): ?>
                <?php foreach ($user as $index => $userItem): ?>

                    <tr>
                        <td><?= $index + 1 ?></td>
                        <td><?= htmlspecialchars($userItem['name']) ?></td>
                        <td><?= htmlspecialchars($userItem['email']) ?></td>
                        <td><?= htmlspecialchars($userItem['gender']) ?></td>
                        <td>
                            <?php if (!empty($userItem['photo'])): ?>
                                <img src="data:image/jpeg;base64,<?= $userItem['photo'] ?>" alt="User Photo" width="50">
                            <?php endif; ?>
                        </td>
                        <td>
                            <button class="edit-btn" data-id="<?= $userItem['id'] ?>" data-name="<?= htmlspecialchars($userItem['name']) ?>" data-email="<?= htmlspecialchars($userItem['email']) ?>" data-gender="<?= htmlspecialchars($userItem['gender']) ?>" data-photo="<?= !empty($userItem['photo']) ? 'data:image/jpeg;base64,' . $userItem['photo'] : '' ?>">Edit</button>
                            <button class="delete-btn" data-id="<?= $userItem['id'] ?>">Delete</button>
                        </td>

                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="6">No users found.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
    <div id="pagination"></div><br><br>
</div>

<?php require_once __DIR__ . "/../layout/footer.php"; ?>