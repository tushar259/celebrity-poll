<template>
    <div>
        <div class="container mt-4">
            <h2>Report a Problem</h2>
            
            <div class="form-group">
                <label for="name">Your Name:</label>
                <input class="form-control" id="name" v-model="name" required>
            </div>
            <div class="form-group">
                <label for="subject">Subject:</label>
                <input class="form-control" id="subject" v-model="subject" required>
            </div>
            <div class="form-group">
                <label for="description">Problem Description:</label>
                <textarea class="form-control" id="description" v-model="description" rows="5" required></textarea>
            </div>
            <button type="submit" class="btn btn-primary">Submit</button>
            
        </div>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                name: '',
                subject: '',
                description: ''
            }
        },

        methods: {
            submitProblem(){
                if(this.name.trim() === '' || this.subject.trim() === '' || this.description.trim() === ''){
                    
                }
            }
        }
    }
</script>
