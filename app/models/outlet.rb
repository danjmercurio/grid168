# == Schema Information
#
# Table name: outlets
#
#  id           :integer(4)      not null, primary key
#  name         :string(255)     not null
#  description  :string(255)
#  subs         :integer(4)      not null
#  dma_id       :integer(4)      not null
#  user_id      :integer(4)      not null
#  created_at   :datetime
#  updated_at   :datetime
#  outlet_type  :integer(4)      default(0), not null
#  first_name   :string(255)
#  last_name    :string(255)
#  phone_number :string(255)
#

class Outlet < ActiveRecord::Base
	belongs_to :user
	belongs_to :dma
  belongs_to :outlet_type
	with_options :dependent => :destroy do |o|
		o.has_many :offers
	end

	attr_accessible :name, :first_name, :last_name, :phone_number, :description, :subs, :dma_id, :user_id,
									:outlet_type_id, :time_zone, :programming, :over_air, :total_homes, :email, :website

	validates :name, :first_name, :last_name, :phone_number, :dma_id, :subs, :outlet_type, :presence => true

	validates :name, uniqueness: { case_sensitive: false, message: 'This outlet name already exists' }

  # Return the number of offers of this outlet with status "Closed Won"
  def won
    self.offers.where(:status => 'Closed Won').length
  end

  # Return the number of offers of this outlet with status "Closed Lost"
  def lost
    self.offers.where(:status => 'Closed Lost').length
  end

	def fullname
		self.first_name + ' ' + self.last_name
	end

end
