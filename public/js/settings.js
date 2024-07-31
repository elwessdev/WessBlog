// Valid Image
document.querySelector(".profile-avatar input").addEventListener("change", () => {
  const fileInput = document.getElementById('image');
  const file = fileInput.files[0];
  if (file) {
    let error = document.querySelector(".profile-header .error");
    error.textContent="";
    if (!['image/jpeg', 'image/png', 'image/gif'].includes(file.type)) {
      error.textContent="Invalid file type. Only JPEG, PNG, and GIF are allowed.";
    } else {
      // Validate file size
      if (file.size > (2 * 1024 * 1024)) {
        error.textContent="File size exceeds the maximum limit of 3MB.";
      } else {
        const img = new Image();
        img.src = URL.createObjectURL(file);
        img.onload = function() {
            const width = img.naturalWidth;
            const height = img.naturalHeight;
            console.log(width);
            console.log(height);
            URL.revokeObjectURL(img.src);
            // Validate image dimensions
            if (width <= 700 && height <= 700) {
                // Show image preview
                const previewImg = document.getElementById('previewImg');
                previewImg.src = URL.createObjectURL(file);
            } else {
              error.textContent="Image dimensions should be 600X600 pixels or less";
            }
        }
        img.onerror = function() {
            alert('Error: Invalid image file.');
        }
      }
    } 
  } else {
    // document.querySelector(".img .error").textContent="No file selected.";
  }
})