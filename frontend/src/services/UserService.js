import axios from "axios";

const USER_API_URL = "http://localhost:8080/api/user";

class UserService {
  getCategoriesUsers(categoryIds) {
    return axios.get(`${USER_API_URL}/userService.php`, {
      params: { categoryIds },
    });
  }

  sendEmails({ categoryIds, message, includeName, includeLastName, useDefaultMessage }) {
    return axios.post(`${USER_API_URL}/sendEmails.php`, {
      categoryIds,
      message,
      includeName,
      includeLastName,
      useDefaultMessage,
    });
  }
}

export default new UserService();
