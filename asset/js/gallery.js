let currentPage = 1;
const imagesPerPage = 10;

async function loadImages(page = 1) {
    const reloadButton = document.getElementById('reloadButton');
    const spinner = reloadButton.querySelector('.spinner-border');
    spinner.classList.remove('d-none'); // Menampilkan spinner

    try {
        const response = await fetch(`fetchimage.php?page=${page}`);
        const data = await response.json();

        // Log data gambar yang diterima
        console.log("Images received:", data);

        // Temukan elemen galeri
        const gridContainer = document.querySelector('.grid-container');
        gridContainer.innerHTML = ''; // Kosongkan konten sebelumnya

        // Menambahkan gambar baru ke grid
        data.images.forEach(image => {
            const gridItem = document.createElement('div');
            gridItem.classList.add('grid-item');

            gridItem.innerHTML = `
                <div class="Img-container">
                    <img src="${image.src}" alt="${image.title}">
                </div>
                <div class="image-description">
                    ${image.title}
                </div>
            `;
            gridContainer.appendChild(gridItem);
        });

        // Tombol navigasi
        const prevPageButton = document.getElementById('prevPageButton');
        const nextPageButton = document.getElementById('nextPageButton');

        // Menonaktifkan tombol Previous jika berada di halaman pertama
        prevPageButton.disabled = (page <= 1);
        
        // Menonaktifkan tombol Next jika tidak ada lagi gambar untuk dimuat
        nextPageButton.disabled = data.images.length < imagesPerPage;

        currentPage = data.current_page;

    } catch (error) {
        console.error('Error loading images:', error);
    } finally {
        spinner.classList.add('d-none'); // Sembunyikan spinner
    }
}

// Panggil pertama kali dengan halaman 1
loadImages(currentPage);

// Fungsi untuk memuat halaman berikutnya
document.getElementById('nextPageButton').addEventListener('click', () => {
    currentPage++;
    loadImages(currentPage);
});

// Fungsi untuk memuat halaman sebelumnya
document.getElementById('prevPageButton').addEventListener('click', () => {
    currentPage--;
    loadImages(currentPage);
});
