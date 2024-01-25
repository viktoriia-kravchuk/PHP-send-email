import axios from 'axios';

const CATEGORY_API_URL = "http://localhost:8080/api/category";

class CategoryService {
    getCategories(){
        return axios.get(`${CATEGORY_API_URL}/read.php`);
    }
}

export default new CategoryService();