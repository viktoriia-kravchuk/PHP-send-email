import React, { useState, useEffect } from "react";
import CategoryService from "../services/CategoryService";
import UserService from "../services/UserService";
import { defaultMessage as defaultText } from "../const";

const EmailForm = () => {
  const [categories, setCategories] = useState([]);
  const [selectedCategories, setSelectedCategories] = useState([]);
  const [message, setMessage] = useState("");
  const [name, addName] = useState(false);
  const [lastName, addLastName] = useState(false);
  const [defaultMessage, addDefaultMessage] = useState(false);
  const [isButtonDisabled, setButtonDisabled] = useState(true);

  useEffect(() => {
    CategoryService.getCategories().then((res) => {
      setCategories(res.data);
    });
  }, []);

  useEffect(() => {
    setButtonDisabled(selectedCategories.length === 0);
  }, [selectedCategories]);

  useEffect(()=>{

    if (defaultMessage===true){
      setMessage(defaultText)
    }else{
      setMessage("")
    }

  },[defaultMessage])

  const handleCheckboxChange = (categoryId) => {
    const index = selectedCategories.indexOf(categoryId);
    if (index === -1) {
      setSelectedCategories([...selectedCategories, categoryId]);
    } else {
      const updatedCategories = [...selectedCategories];
      updatedCategories.splice(index, 1);
      setSelectedCategories(updatedCategories);
    }
  };

  console.log(selectedCategories, "selected");

  const handleSubmit = async (e) => {
    e.preventDefault();
    try {
      const response = await UserService.sendEmails({
        categoryIds: JSON.stringify(selectedCategories),
        message,
        includeName: name,
        includeLastName: lastName,
        useDefaultMessage: defaultMessage,
      });

      console.log(response.data);
    } catch (error) {
      console.error("Error sending emails:", error.message);
    } finally {
      setSelectedCategories([]);
      setMessage("");
      addName(false);
      addLastName(false);
      addDefaultMessage(false);
    }
  };

  console.log(categories);

  return (
    <>
      <div className="container mt-5 p-3 bg-light border shadow-sm rounded">
        <div className="row justify-content-center">
          <div className="col-lg-8">
            <h2>Send Email</h2>
            <form name="email_form" id="email_form" onSubmit={handleSubmit}>
              <div className="mb-1 d-flex flex-row ">
                To:{" "}
                <p className="bg-white border rounded p-2 w-100 h-100 ms-2">
                  {selectedCategories.length > 0
                    ? selectedCategories
                        .map(
                          (categoryId) =>
                            categories.find(
                              (category) => category.id === categoryId
                            ).name
                        )
                        .join(", ")
                    : "No categories selected"}
                </p>
              </div>
              <label>Choose user categories to send email: </label>
              <div
                className="btn-group p-2"
                role="group"
                aria-label="Choose user categories to send email: "
              >
                {categories.map((category) => (
                  <React.Fragment key={category.id}>
                    <input
                      type="checkbox"
                      className="btn-check"
                      id={`btncheck${category.id}`}
                      autoComplete="off"
                      onChange={() => handleCheckboxChange(category.id)}
                      checked={selectedCategories.includes(category.id)}
                    />
                    <label
                      className="btn btn-outline-success"
                      htmlFor={`btncheck${category.id}`}
                    >
                      {category.name}
                    </label>
                  </React.Fragment>
                ))}
              </div>
              <div className="mb-2">
                <label className="form-label pe-2" htmlFor="email_message">
                  Message:
                </label>
                <textarea
                  className="form-control"
                  required
                  rows="7"
                  name="message"
                  value={message}
                  onChange={(e) => setMessage(e.target.value)}
                />
                <div className="mb-2">
                  <label className="form-label pe-2" htmlFor="default_message">
                    Use default message:
                  </label>
                  <input
                    className="form-check-input"
                    type="checkbox"
                    id="default_checkbox"
                    checked={defaultMessage}
                    onChange={() => addDefaultMessage(!defaultMessage)}
                  />
                </div>
              </div>
              <div className="row">
                <div className="col">
                  <label className="form-label pe-2" htmlFor="add_name">
                    Add name:
                  </label>
                  <input
                    className="form-check-input"
                    type="checkbox"
                    id="add_name"
                    checked={name}
                    onChange={() => addName(!name)}
                  />
                </div>

                <div className="col mb-4">
                  <label className="form-label pe-2" htmlFor="add_last_name">
                    Add last name:
                  </label>
                  <input
                    className="form-check-input"
                    type="checkbox"
                    id="add_last_name"
                    checked={lastName}
                    onChange={() => addLastName(!lastName)}
                  />
                </div>
              </div>
              <button
                type="submit"
                className="btn btn-success btn-lg"
                disabled={isButtonDisabled}
              >
                Send Email
              </button>
            </form>
          </div>
        </div>
      </div>
    </>
  );
};

export default EmailForm;
