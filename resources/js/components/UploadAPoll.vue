<template>
    <div class="project-size">
    	
        <label for="exampleInputTitle">Title/Headline</label>
	    <input class="form-control title" id="exampleInputTitle" v-model="headline" placeholder="Enter a headline" :disabled="disabled" @focus="focusedHeadline()" @blur="checkIfUsed()">
	    <small class="form-text text-muted" v-html="headlineMessage" style="color: red !important;"></small>
	    <div class="px-20-gap"></div>
		<label for="exampleFormControlTextarea1">Before details</label>
    	<textarea class="form-control" id="exampleFormControlTextarea1" rows="5" v-model="beforeDetails" @keyup.enter="beforeDetailsEnterPressed()" :disabled="disabled"></textarea>



    	<!-- this is image container -->


    	<div class="container my-3">
  			<div class="row">
			    <div class="col-12 text-center">
			      	<h1 class="mb-3">Upload Image</h1>
			    </div>
			    



			    <!-- <div class="col-md-5 offset-md-1">
			      	<h5>1. single file</h5>
			      	<form>
			        	<div class="form-group">
				          	<label for="my-file">Select Image</label>
					        <input type="file" accept="image/*" @change="previewImage" class="form-control-file" id="my-file">
					    
					        <div class="border p-2 mt-3">
			            		<p>Preview Here:</p>
			            		<template v-if="preview">
			              			<img :src="preview" class="img-fluid" />
			              			<p class="mb-0">file name: {{ image.name }}</p>
			              			<p class="mb-0">size: {{ image.size/1024 }}KB</p>
			            		</template>
			          		</div>
			        	</div>
			      	</form>
			    </div> -->
    




			    <div class="col-md-5">
			      	<h5>2. multiple file</h5>
			      	<form>
			        	<div class="form-group">
			          		<label for="my-file">Select Image</label>
					        <input type="file" accept="image/*" multiple="multiple" @change="previewMultiImage" class="form-control-file" id="my-file" :disabled="disabled">
					    
					        <div class="border p-2 mt-3">
			            		<p>Preview Here:</p>
			            		<template v-if="preview_list.length">
			              			<div v-for="item, index in preview_list" :key="index">
			                			<img :src="item" class="img-fluid" />
			                			<p class="mb-0" v-if="image_list[0]">file name: {{ image_list[index].name }}</p>
			                			<p v-if="image_list[0]">size: {{ image_list[index].size/1024 }}KB</p>
			              			</div>
			            		</template>
			          		</div>
			        	</div>
			      	</form>
			    </div>




    
    			<div class="w-100"></div>
    			<div class="col-12 mt-3 text-center">
      				<p class="text-primary">* You should send data "image" & "image_list" via API to upload image files.</p>
      				Reset input file <button @click="reset" :disabled="disabled">Clear All</button>
    			</div>
  			</div>
		</div>

		<!-- this is image container -->



		<div>
			<span>Add polls</span>
		</div>
		<div class="custom-textarea">
	        <div class="tags-container">
	            <div v-for="(tag, index) in tags" :key="index" class="tag">
	                <span>{{ tag }}</span>
	                <i class="tag-x-close" @click="removeTag(index)">x</i>
	            </div>
	            <input type="text" v-model="tagInput" @keydown.enter.prevent="addTag" placeholder="Add polls..." class="my-input" @focus="focusedField()" @blur="bluredField()" :disabled="disabled">
	        </div>
    	</div>
	    <small class="form-text text-muted" v-html="pollMessage" style="color: red !important;"></small>
		<div class="px-20-gap"></div>
		<label for="exampleFormControlTextarea1">After details</label>
    	<textarea class="form-control" id="exampleFormControlTextarea1" rows="5" v-model="afterDetails" @keyup.enter="afterDetailsEnterPressed()" :disabled="disabled"></textarea>

    	<div class="px-20-gap"></div>
    	<span>Ending date</span>
    	<input type="date" v-model="endingDate">
    	<small class="form-text text-muted" v-html="endingDateMessage" style="color: red !important;"></small>
    	
    	<!-- <div class="row">
    		<div class="col-md-5 offset-md-5" >
    			
    			<button type="button" class="btn btn-info" @click="uploadClicked()" :disabled="disabledUpload">Upload</button>
    		</div>
    	</div> -->
		<div class="px-20-gap"></div>
		<div class="dropdown">
			<button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
				{{whichIndustry}}
			</button>
			<div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
				<a class="dropdown-item cursor-pointer" @click="selectedIndustry($event)">football</a>
				<a class="dropdown-item cursor-pointer" @click="selectedIndustry($event)">cricket</a>
				<a class="dropdown-item cursor-pointer" @click="selectedIndustry($event)">hollywood</a>
				<a class="dropdown-item cursor-pointer" @click="selectedIndustry($event)">bollywood</a>
			</div>
		</div>
    	<small class="form-text text-muted" v-html="whichIndustryMessage" style="color: red !important;"></small>
		
		<div class="px-20-gap"></div>
    	<input class="form-control title" v-model="valueEntered" placeholder="Enter a value" autocomplete="off" autofill="off">
		<div class="px-20-gap"></div>
		<div v-html="uploadPollMessage"></div>
		<div class="d-flex align-items-center">
			<button type="button" class="btn btn-info" @click="uploadClicked()" :disabled="disabledUpload">Upload</button>
			<div class="spinner-border text-primary" :class="{'visually-hidden': uploadPollHideLoading}" role="status">
				<span class="visually-hidden">Loading...</span>
			</div>
			
		</div>
		
		<hr>
    	<div class="px-30-gap"></div>

	    **Polls finished** ({{numberOfNewFinishedPolls}})
		<div>
			<div class="dropdown">
				<button class="btn btn-secondary" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
					{{selectAWinningPoll}}
				</button>
				
				<div class="dropdown-menu" aria-labelledby="dropdownMenuButton" >
					<a class="dropdown-item cursor-pointer" @click="selectedWinningPoll(null,'Select a Poll',null)">Deselect Poll</a>
					<a class="dropdown-item cursor-pointer" v-for="(winningPoll, index) in getPollsWinningList" :key="index" :value="winningPoll.id" @click="selectedWinningPoll(winningPoll.id,winningPoll.poll_title,index)">({{index}}){{winningPoll.poll_title}} ({{winningPoll.ending_date}})</a>
					
				</div>
			</div>
			<!-- <select v-for="(winningPoll, index) in getPollsWinningList" :key="index">
				
				<option @click="selectedWinningPoll(winningPoll.id,winningPoll.poll_title,index)">{{winningPoll.poll_title}}</option>
				
			</select> -->
			<div class="px-50-gap"></div>
			
			<div v-if="selectAWinningPoll != 'Select a Poll'">
				Poll Results
				<div>

					<div  v-for="(poll, index) in getPollsWinningList[selectedPollIndex].poll_tags" :key="index" class="polls-in-page">
						<div class="form-check">
							<input class="form-check-input" type="radio" name="exampleRadios" id="exampleRadio1" :value="poll.id">
							
							<div class="total-votes">
								<div class="votes-received-here" :style="{'width': poll.percent + '%'}"></div>
								<label class="form-check-label d-flex justify-content-between align-items-center" for="exampleRadio1">
									{{poll.polls}}
									<div></div>
									~{{poll.percent}}%({{poll.votes}} votes)
									
								</label>
								
							</div>
						</div>
					</div>

				</div>
			</div>
		</div>
		<div class="px-50-gap"></div>
    </div>
</template>

<script>
    export default {
		data() {
        	return{
        		beforeDetails: '',
				afterDetails: '',
        		preview: null,
			    image: null,
			    preview_list: [],
			    image_list: [],
			    tags: [],
			    tagInput: '',
			    disabledUpload: false,
			    disabledDone: false,
			    valueEntered: '',
			    headline: '',
			    headlineExist: 'no',
			    headlineMessage: '',
			    pollMessage: '',
			    disabled: false,
			    endingDate: '',
			    endingDateMessage: '',
				uploadPollHideLoading: true,
				uploadPollMessage: '',
				whichIndustry: 'Select industry',
				whichIndustryMessage: '',
				selectAWinningPoll: 'Select a Poll',
				getPollsWinningList: [],
				selectedPollIndex: null,
				numberOfNewFinishedPolls: 0,
        	}
        },
        created() {
		  	console.log(window.location.href);
		  	let value = window.location.href.split('uploadapoll/');
		  	console.log(value[1]);
		  	console.log(this.$route.params);
			this.getPollsWinning();
			
		},
        methods: {
        	beforeDetailsEnterPressed(){
        		this.beforeDetails += "<br>";
        	},

			afterDetailsEnterPressed(){
        		this.afterDetails += "<br>";
        	},

        	previewImage: function(event) {
		      	var input = event.target;
		      	if (input.files) {
		        	var reader = new FileReader();
		        	reader.onload = (e) => {
		          		this.preview = e.target.result;
		        	}
		        	this.image=input.files[0];
		        	reader.readAsDataURL(input.files[0]);
		      	}
		    },
		    previewMultiImage: function(event) {
		      	var input = event.target;
		      	var count = input.files.length;
		      	var index = 0;
		      	if (input.files) {
		        	while(count --) {
		          		var reader = new FileReader();
		          		reader.onload = (e) => {
		            		this.preview_list.push(e.target.result);
		          		}
		          		this.image_list.push(input.files[index]);
		          		reader.readAsDataURL(input.files[index]);
		          		index ++;
		        	}
		      	}
		    },
		    reset: function() {
		      	this.image = null;
		      	this.preview = null;
		      	this.image_list = [];
		      	this.preview_list = [];
		    },

		    addTag() {
	            if (this.tagInput.trim() !== '') {
	                this.tags.push(this.tagInput.trim());
	                this.tagInput = '';
	            }
	        },
	        removeTag(index) {
	        	if(this.disabled == false){
	            	this.tags.splice(index, 1);
	        	}
	        },
	        focusedField(){
	            this.focused = true;
	        },
	        bluredField(){
	            this.focused = false;
	        },

	        uploadClicked(){
	        	this.disabledUpload = true;
				this.uploadPollHideLoading = false;
	        	this.headlineMessage = "";
	        	this.pollMessage = "";
				this.endingDateMessage = "";
				this.whichIndustryMessage = "";

	        	if(this.headline == "" || this.tags.length < 2 || this.endingDate == "" || this.whichIndustry == "Select industry" || this.whichIndustry == "" || this.whichIndustry == null){
	        		if(this.headline == ""){
	        			this.headlineMessage = "Headline cannot be empty!";
	        		}
	        		if(this.tags.length < 2){
	        			this.pollMessage = "Atleast 2 polls need to be added";
	        		}
	        		if(this.endingDate == ""){
	        			this.endingDateMessage = "You need to insert a date";
	        		}
					if(this.whichIndustry == "Select industry" || this.whichIndustry == "" || this.whichIndustry == null){
						this.whichIndustryMessage = "You need to select a industry";
					}
					this.uploadPollHideLoading = true;
	        		this.disabledUpload = false;
	        	}
	        	else{
	        		if(this.headlineExist == "headline exist"){
	        			this.headlineMessage = "Headline exist!";
						this.uploadPollHideLoading = true;
	        		}
	        		else{
	        			if(this.valueEntered != ""){
	        				const formData = new FormData();
	        				formData.append('headline', this.headline);
	        				formData.append('beforeDetails', this.beforeDetails);
	        				formData.append('afterDetails', this.afterDetails);
	        				if(this.image_list.length > 0){
	        					formData.append('imageExist', "yes");
	        					for(let i = 0; i < this.image_list.length; i++) {
							        formData.append('images[]', this.image_list[i]);
							    }
	        				}
	        				else{
	        					formData.append('imageExist', "no");
	        				}
	        				
						    for(let i = 0; i < this.tags.length; i++) {
						        formData.append('tags[]', this.tags[i]);
						    }
						    formData.append('valueEntered', this.valueEntered);
						    formData.append('endingDate', this.endingDate);
						    formData.append('whichIndustry', this.whichIndustry);
						    
	        				axios.post('/api/upload-newly-added-poll', formData)
					        .then(response => {
					          	console.log(response.data);
								if(response.data.success == true){
									this.headline = "";
									this.beforeDetails = "";
									this.afterDetails = "";
									this.image_list.splice(0, this.image_list.length);
									this.preview_list.splice(0, this.preview_list.length);
									this.tags.splice(0, this.tags.length);
									// this.preview_list = [];
									// this.tags = [];
									this.valueEntered = "";
									this.endingDate = "";
									this.uploadPollHideLoading = true;
									this.whichIndustry = "Select industry";
									this.uploadPollMessage = '<span style="color:green">'+response.data.message+'</span>';
									setTimeout(() => {
										this.uploadPollMessage = '';
									}, 20000);
									this.disabledUpload = false;
								}
								else{
									this.uploadPollMessage = '<span style="color:red">'+response.data.message+'</span>';
									setTimeout(() => {
										this.uploadPollMessage = '';
									}, 20000);
									this.uploadPollHideLoading = true;
									this.disabledUpload = false;
								}
					          	
					        })
					        .catch(error => {
					          	console.log(error);
								this.uploadPollMessage = '<span style="color:red">Did not get any success message!</span>';
								setTimeout(() => {
									this.uploadPollMessage = '';
								}, 20000);
								this.uploadPollHideLoading = true;
					          	this.disabledUpload = false;
					        });
	        			}
	        			else{
							this.uploadPollHideLoading = true;
	        				this.disabledUpload = false;
	        			}
	        		}
	        	}
	        },

	        focusedHeadline(){
	        	this.headlineMessage = "";
	        },

	        checkIfUsed(){
	        	if(this.headline != ""){
	        		const formData = new FormData();
	        		formData.append('headline', this.headline);
	        		axios.post('/api/check-if-headline-used', formData)
			        .then(response => {
			          	if(response.data.message == "headline exist"){
			          		this.headlineExist = "headline exist";
			          		this.headlineMessage = "Headline exist!";
			          		this.headlineExist = "yes";
			          	}
			          	else if(response.data.message == "headline does not exist"){
			          		this.headlineExist = "headline does not exist";
			          		this.headlineMessage = "";
			          		this.headlineExist = "no";
			          	}
			        })
			        .catch(error => {
			          	console.log(error);
			        });
	        	}
	        },

	        uploadImages() {
			    const formData = new FormData();
			    for(let i = 0; i < this.image_list.length; i++) {
			        formData.append('images[]', this.image_list[i]);
			    }
			    for(let i = 0; i < this.tags.length; i++) {
			        formData.append('tags[]', this.tags[i]);
			    }
			    console.log(formData);
			    axios.post('/api/upload-images', formData)
		        .then(response => {
		          	console.log(response);
		        })
		        .catch(error => {
		          	console.log(error);
		        });
		    },

		    selectedIndustry(event){
				this.whichIndustry = event.target.innerHTML;
			},

		    getPollsWinning(){
                axios.get('/api/get-poll-with-winning-list')
                .then(response => {
                    console.log("all polls");
					this.numberOfNewFinishedPolls = response.data.polls_finished.length;
					response.data.polls_finished.forEach(item => {
						this.getPollsWinningList.push(item);
					});
					console.log(this.getPollsWinningList);
                })
                .catch(error => {
                    console.log(error);
                });
            },

			selectedWinningPoll(id, pollTitle, index){
				console.log("id: "+id);
				if(id != null){
					this.selectAWinningPoll = "("+index +") "+pollTitle;
					this.selectedPollIndex = index;
					// console.log(this.getPollsWinningList[index].poll_tags);
					let totalVotes = 0;
					this.getPollsWinningList[index].poll_tags.forEach(item => {
						totalVotes += item.votes;
					});
					this.getPollsWinningList[index].poll_tags.forEach(item => {
						
						if(((item.votes / totalVotes) * 100).toFixed(2) > 0){
							item.percent = ((item.votes / totalVotes) * 100).toFixed(2);
						}
						else{
							item.percent = 0;
						}
					});
				}
				else{
					this.selectAWinningPoll = pollTitle;
				}
			}
        }
    }
</script>


