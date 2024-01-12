document.addEventListener("DOMContentLoaded", main);

async function main() {
  const allUsers = await getAllUsers();
  const usersTable = getUsersTable(allUsers);
  const usersContainer = document.querySelector("#users");
  usersContainer.innerHTML = usersTable;
}

async function getAllUsers() {
  try {
    const response = await fetch(`/api/users`);
    if (!response.ok) {
      throw new Error(`${response.status} ${response.statusText}`);
    }
    const r = await response.json()
    return r;
  }
  catch (error) {
    console.log(error);
  }
}

function getUsersTable(allUsers) {
  const tableHeaderRow = getUsersTableHeaderRow();
  const tableContent = allUsers.map((user) => getTableRowFromUser(user)).join("");

  return `
        <table class="table-bordered">
            ${tableHeaderRow}
            ${tableContent}
        </table>
    `
}

function getUsersTableHeaderRow() {

  return `
      <tr>
        <th><b>Profile Picture</b></th>
        <th><b>ID</b></th>
        <th><b>Username</b></th>
        <th><b>E-Mail</b></th>
        <th>Created At</th>
      </tr>
    `;
}

function getTableRowFromUser(user) {
  const user_id = user.discord_id;
  const user_name = user.discord_username;
  const user_email = user.discord_email;
  const user_created_at = user.created_at;
  const avatar = user.discord_avatar;
  const avatar_url = avatar ? `https://cdn.discordapp.com/avatars/${user_id}/${avatar}.jpg` : `https://static-cdn.jtvnw.net/jtv_user_pictures/f6dd682a-ce61-40d1-ab3a-54dc6c174092-profile_image-70x70.png`

  return `
      <tr>
        <td class="text-center"><img src="${avatar_url}" height="48" width="48"></td>
        <td><a href="/users/${user_id}">${user_id}</a></td>
        <td>${user_name}</td>
        <td>${user_email}</td>
        <td>${user_created_at}</td>
      </tr>
    `;
}

