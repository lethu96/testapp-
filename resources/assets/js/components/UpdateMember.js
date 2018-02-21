import React, {Component} from 'react';
import {browserHistory} from 'react-router';


class UpdateMember extends Component
{
    constructor(props)
    {
        super(props);
        this.state = {
            position: '',
            selectedposition: '1',
            name: '',
            information: '',
            phone_number: '',
            birthday: '',
            gender: '',
            position_id:'',
            avatar:'',
            error:''
        };
        this.handleChangeName = this.handleChangeName.bind(this);
        this.handleChangeInformation = this.handleChangeInformation.bind(this);
        this.handleChangeBirthday = this.handleChangeBirthday.bind(this);
        this.handleChangeGender = this.handleChangeGender.bind(this);
        this.handleChangePositionId = this.handleChangePositionId.bind(this);
        this.handleChangePhoneNumber = this.handleChangePhoneNumber.bind(this);
        this.handleChangeAvatar = this.handleChangeAvatar.bind(this);
        this.handleSubmit = this.handleSubmit.bind(this);
    }

    componentDidMount()
    {
        axios.get('http://localhost:8000/positions').then(response => {
            this.setState({ position: response.data });
        })
        .catch(function (error) {})
        let current_url = window.location.href;
        let current_id = current_url.split("/").pop();
        axios.get('http://localhost:8000/member/edit/' + current_id)
        .then(response=> {
            this.setState({ name: response.data.name, information: response.data.information,
                birthday: response.data.birthday, gender: response.data.gender, phone_number: response.data.phone_number,selectedposition: response.data.position_id});
        })
        .catch(function (error) {})
    }
    tabRow()
    {
        if (this.state.member instanceof Array) {
            return this.state.member.map(function (member, i) {
                return <TableRowMember obj={member} key={i} />;
            })
        }
    }

    showPosition()
    {
        if (this.state.position instanceof Array) {
            return this.state.position.map(function (position) {
                return (<option key={position.id} value={position.id}>{position.name}</option>);
            })
        }
    }

    handleChangeName(e)
    {
        this.setState({
            name: e.target.value
        })
    }

    handleChangeInformation(e)
    {
        this.setState({
            information: e.target.value
        })
    }

    handleChangeBirthday(e)
    {
        this.setState({
            birthday: e.target.value
        })
    }

    handleChangeGender(e)
    {
        this.setState({
            gender: e.target.value
        })
    }

    handleChangePhoneNumber(e)
    {
        this.setState({
            phone_number: e.target.value
        })
    }

    handleChangeAvatar(e)
    {
        this.setState({
            avatar: this.fileInput.files[0]
        })
    }

    handleChangePositionId(e)
    {
        this.setState({
            selectedposition: e.target.value
        })
    }

    handleSubmit(e)
    {
        e.preventDefault();
        let data = new FormData();
        data.append('name', this.state.name)
        data.append('information', this.state.information)
        data.append('birthday', this.state.birthday)
        data.append('phone_number', this.state.phone_number)
        data.append('gender', this.state.gender)
        data.append('avatar', this.state.avatar)
        data.append('position_id', this.state.selectedposition)
                        console.log(this.state.avatar);
        axios.post('http://localhost:8000/member/edit-item/'+this.props.params.id, data)
        .then(
            (response) => {browserHistory.push('/display-item-member');}
        )
        .catch(error => {
            if (error.response) {
                this.setState({ error: error.response.data.errors });
            }
        });
    }

    render()
    {
        return (
            <div>
                <h1>Create Project</h1>
                <form onSubmit={this.handleSubmit}>
                    <div className="row">
                        <div className="col-md-6">
                            <div className="form-group">
                                <label>Name</label>
                                <input value={this.state.name} type="text" className="form-control" onChange={this.handleChangeName} />
                                <p className="help-block" >{this.state.error.name} </p>
                            </div>
                        </div>
                    </div>
                    <div className="row">
                        <div className="col-md-6">
                            <div className="form-group">
                                <label>birthday</label>
                                <input value={this.state.birthday} type="date" className="form-control" onChange={this.handleChangeBirthday} />
                                <p className="help-block" >{this.state.error.birthday} </p>
                            </div>
                        </div>
                    </div>
                    <div className="row">
                        <div className="col-md-6">
                            <div className="form-group">
                            <label>Information</label>
                            <textarea value={this.state.information}className="form-control col-md-6" onChange={this.handleChangeInformation}></textarea>
                            <p className="help-block" >{this.state.error.information} </p>
                        </div>
                        </div>
                    </div>
                    <div className="row">
                        <div className="col-md-6">
                            <div className="form-group">
                            <label>Phone Number</label>
                            <textarea value={this.state.phone_number}className="form-control col-md-6" onChange={this.handleChangePhoneNumber}></textarea>
                            <p className="help-block" >{this.state.error.phone_number} </p>
                        </div>
                        </div>
                    </div>
                    <div className="row">
                        <div className="col-md-6">
                            <div className="form-group">
                                <label>Gender</label>
                                <select value={this.state.gender} className="form-control" onChange={this.handleChangeGender}>
                                    <option value="">---Option---</option>
                                    <option value="male">Male</option>
                                    <option value="female">Female</option>
                                </select>
                                <p className="help-block" >{this.state.error.gender} </p>
                            </div>
                        </div>
                    </div>
                    <div className="row">
                        <div className="col-md-6">
                            <div className="form-group">
                                <label>Position </label>
                                <select value={this.state.selectedposition} className="form-control" onChange={this.handleChangePositionId}>
                                    {this.showPosition()}
                                </select>
                                <p className="help-block" >{this.state.error.selectedposition} </p>
                            </div>
                        </div>
                    </div>
                    <div className="row">
                        <div className="col-md-6">
                            <div className="form-group">
                            <label>Avatar</label>
                            <input type= "file" ref={input => {
                                this.fileInput = input;
                                }} className="form-control col-md-6" onChange={this.handleChangeAvatar}/>
                            <p className="help-block" >{this.state.error.avatar} </p>
                        </div>
                        </div>
                    </div>
                    <br />
                    <div className="form-group">
                        <button type = "submit" className="btn btn-primary">Add Member</button>
                    </div>
                </form>
            </div>
        )
    }
}
export default UpdateMember;
