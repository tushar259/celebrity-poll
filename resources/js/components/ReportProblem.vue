<template>
    <div>
        <div class="container mt-4">
            <h2>Report a Problem</h2>
            
            <div class="form-group">
                <label for="name">Your Name</label>
                <input class="form-control" id="name" v-model="name" @keyup.enter="submitProblem()" required>
            </div>
            <div class="form-group">
                <label for="subject">Subject</label>
                <input class="form-control" id="subject" v-model="subject" @keyup.enter="submitProblem()" required>
            </div>
            <div class="form-group">
                <label for="description">Problem Description</label>
                <textarea class="form-control" id="description" v-model="description" @keyup.enter="submitProblem()" rows="5" required></textarea>
            </div>
            <button type="submit" class="btn btn-primary" @click="submitProblem()">Submit</button>
            
        </div>
    </div>
</template>

<script>
    import { useToast } from 'vue-toastification';
    const toast = useToast();
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
                    toast.error("Fields cannot be empty!");
                }
                else{
                    const formData = new FormData();
                    formData.append("name", this.name);
                    formData.append("subject", this.subject);
                    formData.append("description", this.description);
                    axios.post('/api/report-a-problem', formData)
                    .then(response =>{
                        console.log(response);
                        if(response.data.success == true){
                            this.name = '';
                            this.subject = '';
                            this.description = '';
                            toast.success(response.data.message);
                        }
                    })
                    .catch(error =>{

                    });
                }
            }
        }
    }
</script>
