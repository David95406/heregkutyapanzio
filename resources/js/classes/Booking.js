export default class Booking {
    #created_at
    #name
    #email
    #phone
    #description
    #start_date
    #end_date
    #isAccepted

    constructor(created_at, name, email, phone, description, start_date, end_date, isAccepted) {
        this.#created_at = created_at
        this.setCreated_at = this.setCreated_at.bind(this)
        this.getCreated_at = this.getCreated_at.bind(this)

        this.#name = name
        this.setName = this.setName.bind(this)
        this.getName = this.getName.bind(this)

        this.#email = email
        this.setEmail = this.setEmail.bind(this)
        this.getEmail = this.getEmail.bind(this)

        this.#phone = phone
        this.setPhone = this.setPhone.bind(this)
        this.getPhone = this.getPhone.bind(this)

        this.#description = description
        this.setDescription = this.setDescription.bind(this)
        this.getDescription = this.getDescription.bind(this)

        this.#start_date = start_date
        this.setStart_date = this.setStart_date.bind(this)
        this.getStart_date = this.getStart_date.bind(this)

        this.#end_date = end_date
        this.setEnd_date = this.setEnd_date.bind(this)
        this.getEnd_date = this.getEnd_date.bind(this)

        this.#isAccepted = isAccepted
        this.setIsaccepted = this.setIsaccepted.bind(this)
        this.getIsaccepted = this.getIsaccepted.bind(this)
    }

    setCreated_at(created_at) {
        this.#created_at = created_at
    }

    getCreated_at() {
        return this.#created_at
    }

    setName(name) {
        this.#name = name
    }

    getName() {
        return this.#name
    }

    setEmail(email) {
        this.#email = email
    }

    getEmail() {
        return this.#email
    }

    setPhone(phone) {
        this.#phone = phone
    }

    getPhone() {
        return this.#phone
    }

    setDescription(description) {
        this.#description = description
    }

    getDescription() {
        return this.#description
    }

    setStart_date(start_date) {
        this.#start_date = start_date
    }

    getStart_date() {
        return this.#start_date
    }

    setEnd_date(end_date) {
        this.#end_date = end_date
    }

    getEnd_date() {
        return this.#end_date
    }

    setIsaccepted(isAccepted) {
        this.#isAccepted = isAccepted
    }

    getIsaccepted() {
        return this.#isAccepted
    }

}