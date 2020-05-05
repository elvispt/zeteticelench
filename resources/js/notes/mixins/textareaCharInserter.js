export const TextareaCharInserter = {
  methods: {
    textareaCharInserter(event, tabChar = '  ') {
      event.preventDefault();
      let text = this.note.body;
      let originalPosition = event.target.selectionStart;
      let textStart = text.slice(0, originalPosition);
      let textEnd = text.slice(originalPosition);
      this.note.body = `${textStart}${tabChar}${textEnd}`;

      event.target.value = this.note.body;
      event.target.selectionEnd = event.target.selectionStart = originalPosition + 1;
    },
  },
}
