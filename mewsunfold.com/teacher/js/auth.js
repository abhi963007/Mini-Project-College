// Query selectors for sign-in and sign-up buttons
const sign_in_btn = document.querySelector("#sign-in-btn");
const sign_up_btn = document.querySelector("#sign-up-btn");
const container = document.querySelector(".container");

// Add event listener to the sign-up button
sign_up_btn.addEventListener("click", () => {
  container.classList.add("sign-up-mode");
});

// Add event listener to the sign-in button
sign_in_btn.addEventListener("click", () => {
  container.classList.remove("sign-up-mode");
});

// Forgot Password Modal functionality
const forgotPasswordLink = document.querySelector("#forgot-password-link");
const forgotPasswordModal = document.querySelector("#forgot-password-modal");
const closeModal = document.querySelector(".close");

// Show the forgot password modal when the link is clicked
forgotPasswordLink.addEventListener("click", () => {
  forgotPasswordModal.style.display = "block";
});

// Close the modal when the user clicks on the "x"
closeModal.addEventListener("click", () => {
  forgotPasswordModal.style.display = "none";
});

// Close the modal when the user clicks anywhere outside the modal content
window.addEventListener("click", (event) => {
  if (event.target == forgotPasswordModal) {
    forgotPasswordModal.style.display = "none";
  }
});

// Additional functionality can be added here as needed
