import React, {Component} from 'react';
import {Link,browserHistory} from 'react-router';


class ShowDetailMember extends Component
{
    constructor(props)
    {
        super(props);
        this.state = {
            position: '',
            selectedposition: '',
            name: '',
            information: '',
            phone_number: '',
            birthday: '',
            gender: '',
            position_id:'',
            avatar:'',
            error:'',
            position_name:''
        };
    }

    componentDidMount()
    {
        let current_url = window.location.href;
        let current_id = current_url.split("/").pop();
        axios.get('http://localhost:8000/member/show/position/' + current_id).then(response => {
            this.setState({ position: response.data.name});
        })
        .catch(function (error) {})
        axios.get('http://localhost:8000/member/' + current_id)
        .then(response=> {
            this.setState({ name: response.data.name, information: response.data.information,
                birthday: response.data.birthday, gender: response.data.gender, phone_number: response.data.phone_number,
                avatar: response.data.avatar,selectedposition: response.data.position_id});
        })
    }

    render()
    {
        return (
            <div>
                <h1>SHOW MEMBER</h1>
                <form >
                    <div className="col-md-6">
                        <div className="row">
                            <div className="col-md-10">
                                <div className="form-group">
                                    <label>NAME :</label>
                                    {this.state.name}
                                </div>
                            </div>
                        </div>
                        <div className="row">
                            <div className="col-md-10">
                                <div className="form-group">
                                    <label>BIRTHDAY :</label>
                                    {this.state.birthday}
                                </div>
                            </div>
                        </div>
                        <div className="row">
                            <div className="col-md-10">
                                <div className="form-group">
                                <label>INFORMATION :</label>
                                <label className="infor">{this.state.information}</label>
                            </div>
                            </div>
                        </div>
                        <div className="row">
                            <div className="col-md-10">
                                <div className="form-group">
                                <label>PHONE NUMBER :</label>
                                {this.state.phone_number}
                            </div>
                            </div>
                        </div>
                        <div className="row">
                            <div className="col-md-10">
                                <div className="form-group">
                                    <label>GENDER :</label>
                                    {this.state.gender}
                                </div>
                            </div>
                        </div>
                        <div className="row">
                            <div className="col-md-10">
                                <div className="form-group">
                                    <label>POSITION :</label>
                                    {this.state.position}
                                </div>
                            </div>
                        </div>
                        <div className="form-group">
                            <Link to="/list" className="btn btn-success">List Member</Link>
                        </div>
                    </div>
                    <div className="col-md-6">
                        <div className="row">
                            <div className="col-md-6">
                                <div className="form-group">
                                <label>AVATAR</label>
                            </div>
                            <img className="img-detail" src={this.state.avatar}/>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        )
    }
}
export default ShowDetailMember;