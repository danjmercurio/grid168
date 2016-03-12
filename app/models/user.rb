# == Schema Information
#
# Table name: users
#
#  id                     :integer(4)      not null, primary key
#  email                  :string(255)     default(""), not null
#  encrypted_password     :string(255)     default(""), not null
#  reset_password_token   :string(255)
#  reset_password_sent_at :datetime
#  remember_created_at    :datetime
#  sign_in_count          :integer(4)      default(0)
#  current_sign_in_at     :datetime
#  last_sign_in_at        :datetime
#  current_sign_in_ip     :string(255)
#  last_sign_in_ip        :string(255)
#  created_at             :datetime
#  updated_at             :datetime
#  admin                  :boolean(1)      default(FALSE)
#  phone                  :string(255)
#  title                  :string(255)
#  first_name             :string(255)
#  last_name              :string(255)
#

class User < ActiveRecord::Base
	with_options :dependent => :destroy do |u|
		u.has_many :programmers
		u.has_many :outlets
		u.has_many :offers
		u.has_many :sub_channel_offers
	end
	
	# Include default devise modules. Others available are:
	# :token_authenticatable, :encryptable, :confirmable, :lockable, :timeoutable and :omniauthable
	devise :database_authenticatable, :registerable,
			:recoverable, :rememberable, :trackable, :validatable

	# Setup accessible (or protected) attributes for your model
	attr_accessible :email, :password, :password_confirmation, :remember_me, :phone, :title,
                  :first_name, :last_name, :admin

	validates :first_name, :last_name, presence: true
	
	def name
		self.first_name + " " + self.last_name
	end

	def count_offers
		offers.count + sub_channel_offers.count
	end #end offers_count method

	# Count all amount bids offers of outlets and amount offers of sub channel
	def count_amount_bids
		amount_offers = Offer.where('user_id = ?', self.id).sum('offers.yearly_offer')
		amount_sub_channel_offers = SubChannelOffer.where('user_id = ?', self.id).sum('sub_channel_offers.yearly_offer')
		amount_offers + amount_sub_channel_offers
	end #end count_amount_offer method

  def admin?
    self.admin
  end

  def self.category_for_highchart(name)
		User.order(:id).select(name).map { |x| x.send name  }
	end

	# Return array amount offer by user for highchart data
	def self.highchart_amount_offers
		User.order(:id).map{ |x| x.count_offers }
	end

	# Return array yearly offer by user for highchart data
	def self.highchart_amount_bids
		User.order(:id).map{ |x| x.count_amount_bids.round(2) }
	end
end
