import axios from "axios";

const EMAIL_API_URL = "http://localhost:8080/api/email";

class EmailService {
  sendEmails({ categoryIds, message, includeName, includeLastName, useDefaultMessage }) {
    return axios.post(`${EMAIL_API_URL}/sendEmails.php`, {
      categoryIds,
      message,
      includeName,
      includeLastName,
      useDefaultMessage,
    });
  }
}

export default new EmailService();
