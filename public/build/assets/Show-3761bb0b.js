import{A as p}from"./AppLayout-540a6a2e.js";import c from"./DeleteUserForm-6b4a925e.js";import l from"./LogoutOtherBrowserSessionsForm-f0f5af3c.js";import{S as s}from"./SectionBorder-5d452737.js";import u from"./TwoFactorAuthenticationForm-089e3873.js";import f from"./UpdatePasswordForm-7ecac648.js";import d from"./UpdateProfileInformationForm-cacc9be8.js";import{o as e,c as _,w as n,a as i,e as r,b as t,h as a,F as h}from"./app-2a871929.js";import"./Dropdown-4ecace4f.js";import"./_plugin-vue_export-helper-c27b6911.js";import"./moment-fbc5633a.js";import"./DialogModal-482037c5.js";import"./SectionTitle-c61a8c1c.js";import"./DangerButton-f4d147e5.js";import"./TextInput-c2bd13c5.js";import"./SecondaryButton-5524b3df.js";import"./ActionMessage-7b8dad33.js";import"./PrimaryButton-6dbb2365.js";import"./InputLabel-ee015f29.js";import"./FormSection-d7f34dd5.js";const g=i("h2",{class:"font-semibold text-xl text-gray-800 leading-tight"}," Profile ",-1),$={class:"max-w-7xl mx-auto py-10 sm:px-6 lg:px-8"},w={key:0},y={key:1},k={key:2},G={__name:"Show",props:{confirmsTwoFactorAuthentication:Boolean,sessions:Array},setup(m){return(o,A)=>(e(),_(p,{title:"Profile"},{header:n(()=>[g]),default:n(()=>[i("div",null,[i("div",$,[o.$page.props.jetstream.canUpdateProfileInformation?(e(),r("div",w,[t(d,{user:o.$page.props.auth.user},null,8,["user"]),t(s)])):a("",!0),o.$page.props.jetstream.canUpdatePassword?(e(),r("div",y,[t(f,{class:"mt-10 sm:mt-0"}),t(s)])):a("",!0),o.$page.props.jetstream.canManageTwoFactorAuthentication?(e(),r("div",k,[t(u,{"requires-confirmation":m.confirmsTwoFactorAuthentication,class:"mt-10 sm:mt-0"},null,8,["requires-confirmation"]),t(s)])):a("",!0),t(l,{sessions:m.sessions,class:"mt-10 sm:mt-0"},null,8,["sessions"]),o.$page.props.jetstream.hasAccountDeletionFeatures?(e(),r(h,{key:3},[t(s),t(c,{class:"mt-10 sm:mt-0"})],64)):a("",!0)])])]),_:1}))}};export{G as default};