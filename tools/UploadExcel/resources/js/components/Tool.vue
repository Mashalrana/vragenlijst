<template>
    <div>
        <h1>Upload Excel</h1>
        <form @submit.prevent="upload">
            <label for="file">Choose file:</label>
            <input type="file" id="file" @change="onFileChange">
            <label for="category">Category:</label>
            <input type="text" v-model="category" id="category" required>
            <label for="filename">Filename:</label>
            <input type="text" v-model="filename" id="filename" required>
            <button type="submit">Upload</button>
        </form>
    </div>
</template>

<script>
export default {
    data() {
        return {
            file: null,
            category: '',
            filename: ''
        }
    },
    methods: {
        onFileChange(e) {
            this.file = e.target.files[0];
        },
        upload() {
            let formData = new FormData();
            formData.append('file', this.file);
            formData.append('category', this.category);
            formData.append('filename', this.filename);

            Nova.request().post('/upload-excel', formData)
                .then(response => {
                    Nova.success('File uploaded successfully!');
                })
                .catch(error => {
                    Nova.error('File upload failed!');
                });
        }
    }
}
</script>
