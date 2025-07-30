export default class Post {
    #id
    #date
    #imageUrl
    #title
    #text
    
    constructor(post) {
        this.setId = this.setId.bind(this)
        this.getId = this.getId.bind(this)
        this.setDate = this.setDate.bind(this)
        this.getDate = this.getDate.bind(this)
        this.setImageurl = this.setImageurl.bind(this)
        this.getImageurl = this.getImageurl.bind(this)
        this.setTitle = this.setTitle.bind(this)
        this.getTitle = this.getTitle.bind(this)
        this.setText = this.setText.bind(this)
        this.getText = this.getText.bind(this)

        this.getFormattedDate = this.getFormattedDate.bind(this)

        if (post) {
            this.setId(post.id)
            this.setDate(post.date)
            this.setImageurl(post.imageUrl)
            this.setTitle(post.title)
            this.setText(post.text)
        }
    }

    setId(id) {
        this.#id = id
    }

    getId() {
        return this.#id
    }

    setDate(date) {
        this.#date = new Date(date)
    }

    getDate() {
        return this.#date
    }

    getFormattedDate() {
        return this.#date.toISOString().split('T')[0]
    }

    setImageurl(imageUrl) {
        this.#imageUrl = imageUrl
    }

    getImageurl() {
        return this.#imageUrl
    }

    setTitle(title) {
        this.#title = title
    }

    getTitle() {
        return this.#title
    }

    setText(text) {
        this.#text = text
    }

    getText() {
        return this.#text
    }
}