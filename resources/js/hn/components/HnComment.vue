<template>
  <div class="hn-comment card mt-3">
    <div class="card-body px-2 px-md-3 shadow">
      <h6 class="card-subtitle bg-light text-muted d-flex justify-content-between align-items-center"
          :class="{ 'opacity-5 text-line-through': comment.deleted }"
      >
        <span class="align-middle" v-if="comment.id">{{ $I18n.trans('hackernews.by', { by: comment.by || '' }) }}</span>
        <small class="text-muted" :title="comment.time">{{ comment.time | diffForHumans }}</small>
        <a role="button"
           class="btn btn-sm pointer btn-collapse"
           data-toggle="collapse"
           @click="handleCollapseToggle(comment)"
           v-if="comment.id"
        >
          <b><!--
            -->[<!--
            --><span v-if="comment.collapsed">{{ comment.kids.length }}</span><!--
            --><span v-else>-</span><!--
            -->]
          </b>
        </a>
      </h6>

      <transition name="slide">
        <div class="mt-2" v-if="!comment.collapsed">
          <p v-html="comment.text"></p>
          <hn-comment
            v-if="comment.comments.length"
            v-for="com in comment.comments"
            v-bind:key="com.id"
            :comment="com"
            :handle-collapse-toggle="handleCollapseToggle"
          ></hn-comment>
        </div>
      </transition>
    </div>
  </div>
</template>

<script>
export default {
  name: "HnComment",

  props: {
    comment: { type: Object, required: true },
    handleCollapseToggle: { type: Function, required: true },
  },

  data() {
    return {
      isShow: true,
    };
  },
}
</script>

<style scoped>
  .slide-enter-active {
    -moz-transition-duration: 0.3s;
    -webkit-transition-duration: 0.3s;
    -o-transition-duration: 0.3s;
    transition-duration: 0.3s;
    -moz-transition-timing-function: ease-in;
    -webkit-transition-timing-function: ease-in;
    -o-transition-timing-function: ease-in;
    transition-timing-function: ease-in;
  }

  .slide-leave-active {
    -moz-transition-duration: 0.3s;
    -webkit-transition-duration: 0.3s;
    -o-transition-duration: 0.3s;
    transition-duration: 0.3s;
    -moz-transition-timing-function: cubic-bezier(0, 1, 0.5, 1);
    -webkit-transition-timing-function: cubic-bezier(0, 1, 0.5, 1);
    -o-transition-timing-function: cubic-bezier(0, 1, 0.5, 1);
    transition-timing-function: cubic-bezier(0, 1, 0.5, 1);
  }

  .slide-enter-to, .slide-leave {
    max-height: 1000px;
    overflow: hidden;
  }

  .slide-enter, .slide-leave-to {
    overflow: hidden;
    max-height: 0;
  }
  .text-line-through {
    text-decoration: line-through;
  }
  .btn-collapse {
    font-family: 'Inconsolata', monospace;
    padding: 0;
    height: 23px;
  }
</style>
