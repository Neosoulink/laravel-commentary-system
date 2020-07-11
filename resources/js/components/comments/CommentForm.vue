<template>
	<form @submit.prevent="submitComment">
		<p v-if="respondTo" class="pl-2 text-muted" style="border-left:4px solid rgba(0,0,0,0.1);">
			En reponse à
			<b>{{ respondTo.user.name }}</b>
			: {{ respondTo.body }}.
			<a
				href="javascript:void(0)"
				@click="$emit('cancel-reply')"
				class="text-dark"
			>
				<i class="fa fa-times"></i> Annuler
			</a>
		</p>
		<div class="input-group">
			<div class="input-group-prepend">
				<span class="input-group-text" id="inputGroupPrepend3">
					<i class="fa fa-envelope"></i>
				</span>
			</div>
			<textarea
				class="form-control rounded-0 rounded-0"
				:class="{ 'is-invalid': errors.body }"
				v-model="form.body"
				placeholder="Commentaire"
			></textarea>
			<div v-if="errors.body" v-text="errors.body[0]" class="invalid-feedback"></div>
		</div>

		<button type="submit" class="btn btn-light border rounded-0 form-control">Commenter</button>
	</form>
</template>

<script>
export default {
	props: ["respondTo"],
	data: () => {
		return {
			form: {
				body: "",
				url: window.location.href
			},
			errors: {}
		};
	},
	computed: {
		fullForm() {
			if (this.respondTo) {
				return {
					...this.form,
					respond_to_id: this.respondTo.id
				};
			}
			return this.form;
		}
	},
	methods: {
		submitComment() {
			axios
				.post("/comments", this.fullForm)
				.then(({ data }) => {
					this.$emit("newComment", data);
					this.$emit("cancel-reply");
					this.form.body = "";
					this.errors = {};
				})
				.catch(error => {
					this.errors = error.response.data.errors;
				});
		}
	}
};
</script>
