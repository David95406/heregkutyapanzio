import { getDayFromDate } from "../utils"

export default class Booking {
    #id
    #created_at
    #name
    #email
    #phone
    #description
    #start_date
    #end_date
    #accepted
    #verification_token
    #verified_at

    constructor(booking) {
        this.setId = this.setId.bind(this)
        this.getId = this.getId.bind(this)
        this.setCreated_at = this.setCreated_at.bind(this)
        this.getCreated_at = this.getCreated_at.bind(this)
        this.setName = this.setName.bind(this)
        this.getName = this.getName.bind(this)
        this.setEmail = this.setEmail.bind(this)
        this.getEmail = this.getEmail.bind(this)
        this.setPhone = this.setPhone.bind(this)
        this.getPhone = this.getPhone.bind(this)
        this.setDescription = this.setDescription.bind(this)
        this.getDescription = this.getDescription.bind(this)
        this.setStart_date = this.setStart_date.bind(this)
        this.getStart_date = this.getStart_date.bind(this)
        this.setEnd_date = this.setEnd_date.bind(this)
        this.getEnd_date = this.getEnd_date.bind(this)
        this.setAccepted = this.setAccepted.bind(this)
        this.getAccepted = this.getAccepted.bind(this)
        this.setVerification_token = this.setVerification_token.bind(this)
        this.getVerification_token = this.getVerification_token.bind(this)
        this.setVerified_at = this.setVerified_at.bind(this)
        this.getVerified_at = this.getVerified_at.bind(this)
        this.isDayCare = this.isDayCare.bind(this)
        this.getBookingTypeString = this.getBookingTypeString.bind(this)
        this.getVerificationText = this.getVerificationText.bind(this)
        this.getAcceptedString = this.getAcceptedString.bind(this)

        if (booking) {
            this.setId(booking.id)
            this.setCreated_at(booking.created_at)
            this.setName(booking.name)
            this.setEmail(booking.email)
            this.setPhone(booking.phone)
            this.setDescription(booking.description)
            this.setStart_date(booking.start_date)
            this.setEnd_date(booking.end_date)
            this.setAccepted(booking.accepted)
            this.setVerification_token(booking.verification_token)
            this.setVerified_at(booking.verified_at)
        }
    }

    toString() {
        return `Booking: ${this.getName()}, ${this.getEmail()}, ${this.getPhone()}, ${this.getBookingTypeString()}, ${this.getAcceptedString()}, ${this.getVerificationText()}`
    }

    isDayCare() {
        return getDayFromDate(this.#start_date) == getDayFromDate(this.#end_date)
    }

    getBookingTypeString() {
        return this.isDayCare() ? "Napközi" : "Panzió"
    }

    getAcceptedString() {
        return (typeof this.getAccepted() === 'boolean') ? this.getAccepted() ? "Elfogadva" : "Elutasítva" : "Függőben"
    }

    getVerificationText() {
        return this.#verified_at ? "Megerősített" : "Nem megerősített"
    }

    setId(id) {
        this.#id = id
    }

    getId() {
        return this.#id
    }

    setCreated_at(created_at) {
        this.#created_at = created_at ? new Date(created_at) : null
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
        this.#start_date = start_date ? new Date(start_date) : null
    }

    getStart_date() {
        return this.#start_date
    }

    setEnd_date(end_date) {
        this.#end_date = end_date ? new Date(end_date) : null
    }

    getEnd_date() {
        return this.#end_date
    }

    setAccepted(accepted) {
        this.#accepted = accepted
    }

    getAccepted() {
        return this.#accepted
    }

    setVerification_token(verification_token) {
        this.#verification_token = verification_token
    }

    getVerification_token() {
        return this.#verification_token
    }

    setVerified_at(verified_at) {
        this.#verified_at = verified_at ? new Date(verified_at) : null
    }

    getVerified_at() {
        return this.#verified_at
    }
}
