document.addEventListener('DOMContentLoaded', (event) => {
    const video = document.getElementById('video');
    const canvas = document.getElementById('canvas');
    const photo = document.getElementById('photo');
    const captureButton = document.getElementById('capture-btn');
    let stream;

    // Dapatkan daftar perangkat media
    navigator.mediaDevices.enumerateDevices()
        .then(devices => {
            const videoDevices = devices.filter(device => device.kind === 'videoinput');
            const rearCamera = videoDevices.find(device => device.label.includes('back') || device.label.includes('rear'));

            // Pilih kamera belakang jika tersedia
            const constraints = {
                video: {
                    deviceId: rearCamera ? { exact: rearCamera.deviceId } : undefined,
                },
            };

            // Mengakses kamera dengan constraints
            return navigator.mediaDevices.getUserMedia(constraints);
        })
        .then((stream) => {
            video.srcObject = stream;
            stream = stream;
        })
        .catch((err) => console.error('Error accessing camera:', err));

    // Mengambil foto dari kamera
    captureButton.addEventListener('click', () => {
        canvas.getContext('2d').drawImage(video, 0, 0, 640, 480);
        const dataURL = canvas.toDataURL('image/png');
        photo.setAttribute('src', dataURL);

        // Kirim data foto ke server menggunakan AJAX atau fetch
        fetch('save_photo.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
            },
            body: 'data=' + encodeURIComponent(dataURL),
        })
            .then((response) => response.json())
            .then((data) => console.log('Photo saved:', data))
            .catch((error) => console.error('Error saving photo:', error));
    });
});