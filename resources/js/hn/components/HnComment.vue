<template>
  <div class="hn-comment card mt-3">
    <div class="card-body px-2 px-md-3 shadow">
      <h6 class="card-subtitle bg-light text-muted d-flex justify-content-between align-items-center">
        <span class="align-middle">by {{ comment.by }}</span>
        <small class="text-muted">{{ comment.time | diffForHumans }}</small>
      </h6>

      <div class="mt-2">
        <p v-html="comment.text"></p>
        <hn-comment
          v-if="comment.comments.length"
          v-for="com in comment.comments"
          v-bind:key="com.id"
          :comment="com"
        ></hn-comment>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  name: "HnComment",

  props: {
    comment: { type: Object, required: true },
  },
}
</script>
