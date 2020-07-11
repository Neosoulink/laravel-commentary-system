<template>
	<div class="row">
		<div class="offset-md-4 offset-sm-0 col-md-4 mr-auto">
			<legend class="text-muted">Commenter dans notre site</legend>

			<comment-form @newComment="newComment" :respond-to="respondTo" @cancel-reply="respondTo = null"></comment-form>
		</div>
		<div class="offset-md-4 offset-sm-0 col-md-4 mr-auto mt-4">
			<ul class="list-group list-group-flush">
				<legend class="text-muted">List of comments</legend>
				<comment
					v-for="comment in comments"
                    :current-user='currentUser'
					:key="comment.id"
					:comment="comment"
					:now="now"
					@dropComment="dropComment"
					@respond-to="respondTo = $event"
				></comment>
			</ul>
			<div class="text-center" v-if="nextPageUrl">
				<small>
					<a href="javascript:void(0)" @click="fetchComments(nextPageUrl)" class="text-dark">
						{{ numberOfComments - comments.length }} commentaire(s)
						restant. Charger les commentaires...
					</a>
				</small>
			</div>
		</div>
	</div>
</template>

<script>
import CommentForm from "./CommentForm";
import Comment from "./Comment";

export default {
    components: { CommentForm, Comment },
    props: ["currentUser"],
	data: () => {
		return {
			comments: [],
			now: new Date(),
			respondTo: null,
			deleteComment: null,
			nextPageUrl: null,
			numberOfComments: 0
		};
	},
	mounted() {
		this.fetchComments("/comments/" + btoa(window.location.href));

		setInterval(() => {
			this.now = new Date();
		}, 1000);
	},
	methods: {
		newComment(comment) {
			if (!this.respondTo) {
				this.comments.unshift(comment);
				return;
			}
			this.respondTo.children.unshift(comment);
		},
		fetchComments(url, concat_ = true) {
			axios.get(url).then(({ data: paginate }) => {
				concat_
					? (this.comments = this.comments.concat(paginate.data))
					: (this.comments = paginate.data);
				this.nextPageUrl = paginate.next_page_url;
				this.numberOfComments = paginate.total;
			});
		},
		dropComment(comment) {
			if (!comment.respond_to_id) {
				this.comments = this.comments.filter(i => i != comment);
				return;
			}
			this.dropHasChild(this.comments, comment);
		},
		dropHasChild(comment, getComment) {
			comment
				.filter(i => i.children)
				.forEach(i => {
					i.children = i.children.filter(i => i != getComment);
					if (i.children.length > 0) {
                        this.dropHasChild(i.children, getComment);
					}
				});
		}
	}
};
</script>
