<template>
  <div>
    <li class="list-group-item bg-transparent border-bottom shadow-sm mb-3">
      <div>
        <div class="mb-1">
          <small class="text-muted d-block">{{ comment.user.name }} - il y a {{ diffForHimans }}</small>
          <div v-if="edit">
            <textarea class="form-control" v-model="newBody"></textarea>
          </div>
          <div v-else-if="del">
            <span class="text-danger">Voulez vous réellement supprimer ce commentaire ?</span>
          </div>
          <div v-else>{{ comment.body }}</div>
        </div>
        <div class="text-right" v-if="edit">
          <button type="button" class="btn btn-light btn-sm" @click="reset()">
            <i class="fa fa-times"></i> Annuler
          </button>
          <button type="button" class="btn btn-light btn-sm" @click="update()">
            <i class="fa fa-save"></i> Sauvegarder
          </button>
        </div>
        <div class="text-right" v-else-if="del">
          <button type="button" class="btn btn-light btn-sm" @click="reset()">
            <i class="fa fa-times"></i> Annuler
          </button>
          <button type="button" class="btn btn-light btn-sm" @click="drop()">
            <i class="fa fa-check"></i> Confirmer
          </button>
        </div>
        <div class="text-right" v-else>
          <button
            type="button"
            class="btn btn-light btn-sm"
            @click="$emit('respond-to', comment);goToTop()"
          >
            <i class="fa fa-reply"></i> Repondre
          </button>
          <button type="button" class="btn btn-light btn-sm" @click="edit = true" v-if="comment.user.id === currentUser.id">
            <i class="fa fa-edit"></i> Modifier
          </button>
          <button type="button" class="btn btn-light btn-sm" @click="del = true" v-if="comment.user.id === currentUser.id">
            <i class="fa fa-trash"></i> Supprimer
          </button>
        </div>
      </div>
    </li>
    <div class="pl-2" style="border-left:4px solid rgba(0,0,0,0.1);">
      <comment
        v-for="children in comment.children"
        :key="children.id"
        :current-user='currentUser'
        :comment="children"
        :now="now"
        @respond-to="$emit('respond-to', $event)"
        @dropComment="$emit('dropComment', $event)"
      ></comment>
    </div>
  </div>
</template>
<script>
import { formatDistance } from "date-fns";
import { fr } from "date-fns/locale";

export default {
  name: "comment",
  props: ["comment", "now", "currentUser"],
  data() {
    return {
      edit: false,
      del: false,
      newBody: this.comment.body
    };
  },
  computed: {
    diffForHimans() {
      return formatDistance(new Date(this.comment.created_at), this.now, {
        locale: fr
      });
    }
  },
  methods: {
    goToTop() {
      window.scrollTo(0, 0);
    },
    reset() {
      this.newBody = this.comment.body;
      this.edit = false;
      this.del = false;
    },
    update() {
      this.comment.body = this.newBody;
      this.reset();
      axios
        .put("/comments/" + this.comment.id, this.comment)
        .then(res => {
          console.log(res);
        })
        .catch(err => {
          console.error(err);
        });
    },
    drop() {
        axios
        .delete("/comments/" + this.comment.id)
        .then(res => {
            this.reset();
            this.$emit("dropComment", this.comment);
          console.log(res);
        })
        .catch(err => {
          console.error(err);
        });
    }
  },
  destroyed() {
    // console.log("good bay");
  }
};
</script>
